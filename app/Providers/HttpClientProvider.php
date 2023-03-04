<?php

namespace App\Providers;

use App\Infrastructure\Config\ConfigService;
use App\Infrastructure\Logger\VKHttpClientLogger;
use App\Infrastructure\VK\Client\HttpClient;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application;
use Psr\Http\Client\ClientInterface;

class HttpClientProvider extends ServiceProvider
{
    private const VK_HTTP_CLIENT = 'vk-api-client';

    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(ClientInterface::class, static function (Application $app) {
            return new Client();
        });

        $this->app->bind(HttpClient::class, static function (Application $app) {
            /** @var ConfigService $configService */
            $configService = $app->get(ConfigService::class);
            $config = $configService->get(self::VK_HTTP_CLIENT);

            $host = $config['host'] ?? null;
            if ($host === null) {
                throw new \InvalidArgumentException('Invalid config ' . self::VK_HTTP_CLIENT . ': no valid \'host\' defined');
            }

            $version = $config['version'] ?? null;
            if ($version === null) {
                throw new \InvalidArgumentException('Invalid config ' . self::VK_HTTP_CLIENT . ': no valid \'version\' defined');
            }

            $host = rtrim($host, '/');
            return new HttpClient(
                $app->get(VKHttpClientLogger::class),
                $app->get(ClientInterface::class),
                $host,
                $version
            );
        });
    }
}
