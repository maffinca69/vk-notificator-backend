<?php

namespace App\Services\VK\OAuth;

use App\Infrastructure\Telegram\Client\Exception\TelegramHttpClientException;
use App\Models\User;
use App\Services\Telegram\DTO\MessageRequestDTO;
use App\Services\Telegram\MessageSendingService;
use App\Services\User\VKUserCreatingService;
use App\Services\VK\OAuth\Assembler\VKOauthDTOAssembler;

class VKOauthCallbackService
{
    private const SUCCESS_AUTH_MESSAGE = '🎉 Вы успешно авторизовались. Бот начнет рассылку уведомлений автоматически';

    public function __construct(
        private VKOauthDTOAssembler $VKOauthDTOAssembler,
        private VKUserCreatingService $VKUserCreatingService,
        private MessageSendingService $messageSendingService
    ) {
    }

    /**
     * @param array $params
     * @throws TelegramHttpClientException
     */
    public function process(array $params): void
    {
        $oauthDTO = $this->VKOauthDTOAssembler->create($params);
        $vkUser = $this->VKUserCreatingService->create($oauthDTO);
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
