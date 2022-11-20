<?php

namespace App\Services\Telegram\Client;

use App\Infrastructure\Logger\TelegramClientLogger;
use App\Services\Telegram\Client\Assembler\TelegramResponseDTOAssembler;
use App\Services\Telegram\Client\DTO\TelegramResponseDTO;
use App\Services\Telegram\Client\Exception\InvalidTelegramResponseException;
use App\Services\Telegram\Client\Request\Request;
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
     */
    public function __construct(
        private TelegramResponseDTOAssembler $responseDTOAssembler,
        private Client $client,
        private TelegramClientLogger $logger
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
        $token = config('bot.token');

        return sprintf(self::BASE_API_URL, $token);
    }

    /**
     * @param Request $request
     * @return TelegramResponseDTO
     * @throws InvalidTelegramResponseException
     */
    public function sendRequest(Request $request): TelegramResponseDTO
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

        $this->logger->info('Telegram Request', [
            'method' => $method,
            'endpoint' => $endpoint,
            'options' => $options,
        ]);

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
        $this->logger->info('Telegram Response', $response);
        return $this->responseDTOAssembler->create($response);
    }
}
