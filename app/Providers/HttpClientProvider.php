<?php

namespace App\Providers;

use App\Infrastructure\Config\ConfigService;
use App\Infrastructure\Logger\TelegramClientLogger;
use App\Infrastructure\Logger\VKHttpClientLogger;
use App\Infrastructure\VK\Client\HttpClient as VKHttpClient;
use App\Infrastructure\Telegram\Client\HttpClient as TelegramHttpClient;
use App\Services\Telegram\Translator\TelegramResponseTranslator;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application;
use Psr\Http\Client\ClientInterface;

class HttpClientProvider extends ServiceProvider
{
    private const VK_HTTP_CLIENT = 'vk-client';
    private const TELEGRAM_HTTP_CLIENT = 'telegram-client';

    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(ClientInterface::class, static function (Application $app) {
            return new Client();
        });

        $this->app->bind(VKHttpClient::class, static function (Application $app) {
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
            return new VKHttpClient(
                $app->get(VKHttpClientLogger::class),
                $app->get(ClientInterface::class),
                $host,
                $version
            );
        });

        $this->app->bind(TelegramHttpClient::class, static function (Application $app) {
            /** @var ConfigService $configService */
            $configService = $app->get(ConfigService::class);
            $config = $configService->get(self::TELEGRAM_HTTP_CLIENT);

            $baseUrl = $config['base_url'] ?? null;
            if ($baseUrl === null) {
                throw new \InvalidArgumentException('Invalid config ' . self::TELEGRAM_HTTP_CLIENT . ': no valid \'base_url\' defined');
            }

            $botToken = $config['bot_token'] ?? null;
            if ($botToken === null) {
                throw new \InvalidArgumentException('Invalid config ' . self::TELEGRAM_HTTP_CLIENT . ': no valid \'bot_token\' defined');
            }

            $baseUrl .= $botToken;
            return new TelegramHttpClient(
                $app->get(TelegramResponseTranslator::class),
                $app->get(ClientInterface::class),
                $app->get(TelegramClientLogger::class),
                $baseUrl
            );
        });
    }
}
