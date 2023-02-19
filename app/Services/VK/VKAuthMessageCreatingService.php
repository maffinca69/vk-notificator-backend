<?php

namespace App\Services\VK;

use App\Core\DTO\UpdateDTO;
use App\Infrastructure\Config\ConfigService;
use App\Services\Telegram\Client\DTO\MessageRequestDTO;

class VKAuthMessageCreatingService
{
    private const BASE_URL = 'https://oauth.vk.com/authorize';
    private const SCOPE = 232763359;
    private const DISPLAY = 'page';
    private const RESPONSE_TYPE = 'token';
    private const REVOKE = true;

    /**
     * @param ConfigService $configService
     */
    public function __construct(private ConfigService $configService)
    {
    }

    /**
     * @param UpdateDTO $updateDTO
     * @return MessageRequestDTO
     */
    public function create(UpdateDTO $updateDTO): MessageRequestDTO
    {
        $fromId = $updateDTO->getMessage()->getFrom()->getId();

        $message = new MessageRequestDTO($updateDTO->getChatId());
        $message->setText('🔒 Нужно выполнить вход через VK');
        $message->setReplyMarkup([
            'inline_keyboard' => [
                [
                    [
                        'text' => 'Войти',
                        'url' => $this->createOAuthUrl((string) $fromId),
                    ]
                ]
            ]
        ]);

        return $message;
    }

    /**
     * @param string $state
     * @return string
     */
    private function createOAuthUrl(string $state): string
    {
        $vkAppConfig = $this->configService->get('vk-app');

        $queryParams = [
            'client_id' => $vkAppConfig['app_id'],
            'scope' => self::SCOPE,
            'redirect_uri' => $vkAppConfig['redirect_uri'],
            'display' => self::DISPLAY,
            'response_type' => self::RESPONSE_TYPE,
            'revoke' => (int) self::REVOKE,
            'state' => $state,
        ];

        $query = http_build_query($queryParams);

        return sprintf('%s?%s',
            self::BASE_URL,
            $query
        );
    }
}
