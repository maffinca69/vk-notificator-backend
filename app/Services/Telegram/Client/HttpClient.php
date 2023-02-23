<?php

namespace App\Services\Telegram\Client;

use App\Infrastructure\Config\ConfigService;
use App\Infrastructure\Logger\TelegramClientLogger;
use App\Services\Telegram\Client\Assembler\TelegramResponseDTOAssembler;
use App\Services\Telegram\Client\DTO\TelegramResponseDTO;
use App\Services\Telegram\Client\Exception\InvalidTelegramResponseException;
use App\Services\Telegram\Client\Request\AbstractRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;

class HttpClient
{
    private const BASE_API_URL = 'https://api.telegram.org/bot%s/';

    /**
     * @param TelegramResponseDTOAssembler $responseDTOAssembler
     * @param Client $client
     * @param TelegramClientLogger $logger
     * @param ConfigService $configService
     */
    public function __construct(
        private TelegramResponseDTOAssembler $responseDTOAssembler,
        private Client $client,
        private TelegramClientLogger $logger,
        private ConfigService $configService
    ) {
        $this->client = new Client([
            'base_uri' => $this->getBaseURI()
        ]);
    }

    /**
     * @return string
     */
    private function getBaseURI(): string
    {
        $config = $this->configService->get('bot');
        $token = $config['token'] ?? null;

        if ($token === null) {
            throw new \RuntimeException('Invalid configure bot. Token is required');
        }

        return sprintf(self::BASE_API_URL, $token);
    }

    /**
     * @param AbstractRequest $request
     * @return TelegramResponseDTO
     * @throws InvalidTelegramResponseException
     */
    public function sendRequest(AbstractRequest $request): TelegramResponseDTO
    {
        $endpoint = $request->getEndpoint();
        $requestParams = $request->getParams();
        $method = $request->getMethod();

        $options = [
            RequestOptions::JSON => $requestParams,
            RequestOptions::HEADERS => [
                'Accept-Encoding' => 'gzip, deflate, br'
            ]
        ];

        $this->logRequest($request);

        try {
            $response = $this->client->request($method, $endpoint, $options);
        } catch (ClientException|GuzzleException $e) {
            $content = $e->getResponse()->getBody()->getContents();
            $this->logger->critical('Telegram error!', [
                'response' => $content,
                'code' => $e->getCode()
            ]);
            throw new InvalidTelegramResponseException($content);
        }

        $response = json_decode($response->getBody()->getContents(), true);
        $this->logResponse($response);
        return $this->responseDTOAssembler->create($response);
    }

    /**
     * @param AbstractRequest $request
     * @return void
     */
    private function logRequest(AbstractRequest $request): void
    {
        $this->logger->info('Telegram request', [
            'method' => $request->getMethod(),
            'endpoint' => $request->getEndpoint(),
            'options' => $request->getParams(),
        ]);
    }

    /**
     * @param array $response
     * @return void
     */
    private function logResponse(array $response): void
    {
        $this->logger->info('Telegram Response', $response);
    }
}
