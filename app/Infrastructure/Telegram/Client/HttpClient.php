<?php

namespace App\Infrastructure\Telegram\Client;

use App\Infrastructure\Logger\TelegramClientLogger;
use App\Infrastructure\Telegram\Client\Exception\InvalidTelegramResponseException;
use App\Infrastructure\Telegram\Client\Request\AbstractRequest;
use App\Services\Telegram\DTO\TelegramResponseDTO;
use App\Services\Telegram\Translator\TelegramResponseTranslator;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Psr\Log\LoggerInterface;

class HttpClient
{
    /**
     * @param TelegramResponseTranslator $translator
     * @param Client $client
     * @param TelegramClientLogger $logger
     * @param string $baseUrl
     */
    public function __construct(
        private TelegramResponseTranslator $translator,
        private Client $client,
        private LoggerInterface $logger,
        private string $baseUrl
    ) {
    }

    /**
     * @param AbstractRequest $request
     * @return TelegramResponseDTO
     * @throws InvalidTelegramResponseException
     */
    public function sendRequest(AbstractRequest $request): TelegramResponseDTO
    {
        $endpoint = $this->baseUrl . '/' .$request->getEndpoint();
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
        return $this->translator->translate($response);
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