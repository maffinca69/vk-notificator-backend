<?php

namespace App\Services\Telegram\Client;

use App\Services\Telegram\Client\Assembler\TelegramResponseDTOAssembler;
use App\Services\Telegram\Client\DTO\TelegramResponseDTO;
use App\Services\Telegram\Client\Exception\InvalidTelegramResponseException;
use App\Services\Telegram\Client\Request\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Log;

class HttpClient
{
    private const BASE_API_URL = 'https://api.telegram.org/bot%s/';

    private Client $client;
    private TelegramResponseDTOAssembler $responseDTOAssembler;

    /**
     * @param TelegramResponseDTOAssembler $responseDTOAssembler
     */
    public function __construct(TelegramResponseDTOAssembler $responseDTOAssembler)
    {
        $this->client = new Client([
            'base_uri' => $this->getBaseURI()
        ]);
        $this->responseDTOAssembler = $responseDTOAssembler;
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

        Log::info('requestParams', $requestParams);

        try {
            $response = $this->client->request($method, $endpoint, $options);
        } catch (ClientException $e) {
            $message = $e->getResponse()->getBody()->getContents();
            Log::error($message);
            throw new InvalidTelegramResponseException($message);
        } catch (GuzzleException $exception) {
            $responseBody = $exception->getResponse()->getBody(true);
            Log::error($responseBody);
            throw new InvalidTelegramResponseException($exception->getMessage());
        }

        $response = json_decode($response->getBody()->getContents(), true);
        Log::info($response);
        return $this->responseDTOAssembler->create($response);
    }
}