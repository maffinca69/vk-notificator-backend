<?php

namespace App\Services\VK\OAuth;

use App\Domain\Service\VKUser\VKUserCreatingService;
use App\Infrastructure\Telegram\Client\Exception\TelegramHttpClientException;
use App\Models\User;
use App\Services\Telegram\DTO\Request\MessageRequestDTO;
use App\Services\Telegram\MessageSendingService;
use App\Services\VK\OAuth\DTO\VKOAuthDTO;

class VKOauthCallbackService
{
    private const SUCCESS_AUTH_MESSAGE = '🎉 Вы успешно авторизовались. Бот начнет рассылку уведомлений автоматически';

    /**
     * @param VKUserCreatingService $VKUserCreatingService
     * @param MessageSendingService $messageSendingService
     */
    public function __construct(
        private VKUserCreatingService $VKUserCreatingService,
        private MessageSendingService $messageSendingService
    ) {
    }

    /**
     * @param VKOAuthDTO $VKOAuthDTO
     * @throws TelegramHttpClientException
     */
    public function process(VKOAuthDTO $VKOAuthDTO): void
    {
        $vkUser = $this->VKUserCreatingService->create($VKOAuthDTO);
        $this->sendSuccessfulAuthMessage($vkUser->user);
    }

    /**
     * @param User $user
     * @throws TelegramHttpClientException
     */
    private function sendSuccessfulAuthMessage(User $user): void
    {
        $requestDTO = new MessageRequestDTO(
            chatId: $user->getUuid(),
            text: self::SUCCESS_AUTH_MESSAGE
        );

        $this->messageSendingService->send($requestDTO);
    }
}
