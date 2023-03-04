<?php

namespace App\Infrastructure\VK\Client;

use App\Infrastructure\Logger\VKHttpClientLogger;
use App\Infrastructure\VK\Client\Exception\VKAPIHttpClientException;
use App\Infrastructure\VK\Client\Request\AbstractRequest;
use GuzzleHttp\RequestOptions;
use Psr\Http\Client\ClientInterface;
use Symfony\Component\HttpFoundation\Request as HttpRequest;


class HttpClient
{
    private const REQUEST_HEADERS = [
        'Accept-Encoding' => 'gzip,deflate',
    ];

    /**
     * @param VKHttpClientLogger $logger
     * @param ClientInterface $client
     * @param string $host
     * @param string $version
     */
    public function __construct(
        private VKHttpClientLogger $logger,
        private ClientInterface $client,
        private string $host,
        private string $version
    ) {
    }

    /**
     * @param AbstractRequest $request
     *
     * @return array
     *
     * @throws VKAPIHttpClientException
     */
    public function sendRequest(AbstractRequest $request): array
    {
        $method = $request->getMethod();
        $url = $this->host . '/' . $request->getEndpoint();

        $requestParams = $request->getParams();
        $requestParams['v'] = $this->version;

        $options = [
            RequestOptions::HEADERS => self::REQUEST_HEADERS
        ];

        switch ($method) {
            case HttpRequest::METHOD_GET:
                $options[RequestOptions::QUERY] = $requestParams;
                break;
            case HttpRequest::METHOD_POST:
                $options[RequestOptions::JSON] = $requestParams;
                break;
        }

        $this->logger->notice("Request [{$method} {$url}]:", [
            'params' => $requestParams,
            'options' => $options,
        ]);

        try {
            $response = $this->client->request($method, $url, $options);
        } catch (\Throwable $e) {
            $message = 'VK API request error';
            $this->logger->error($message, [
                'url' => $url,
                'message' => $e->getMessage(),
                'exception' => $e,
            ]);

            throw new VKAPIHttpClientException($message);
        }

        $rawResponse = $response->getBody()->getContents();
        $decodedResponse = json_decode($rawResponse, true);

        $this->logger->debug("Response [{$method} {$url}]:", ['response' => $decodedResponse ?: $rawResponse]);

        if ($decodedResponse === null) {
            $message = 'Could not decode VK API response';
            $this->logger->error('VK API error', ['message' => $message]);
            throw new VKAPIHttpClientException($message);
        }

        $data = $decodedResponse['response'] ?? null;
        if ($data === null) {
            $message = 'Invalid VK API response, response is missing';
            $this->logger->error('VK API error', ['message' => $message]);
            throw new VKAPIHttpClientException($message);
        }

        return $data;
    }
}
