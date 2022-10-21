<?php

namespace App\Services\VK\OAuth;

use App\Models\User;
use App\Services\Telegram\Client\DTO\MessageRequestDTO;
use App\Services\Telegram\Client\Exception\InvalidTelegramResponseException;
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
     * @throws InvalidTelegramResponseException
     */
    public function process(array $params)
    {
        $oauth = $this->VKOauthDTOAssembler->create($params);
        $vkUser = $this->VKUserCreatingService->create($oauth);
        $this->sendSuccessfulAuthMessage($vkUser->user);
    }

    /**
     * @param User $user
     * @throws InvalidTelegramResponseException
     */
    private function sendSuccessfulAuthMessage(User $user): void
    {
        $requestDTO = new MessageRequestDTO($user->uuid);
        $requestDTO->setText(self::SUCCESS_AUTH_MESSAGE);

        $this->messageSendingService->send($requestDTO);
    }
}
