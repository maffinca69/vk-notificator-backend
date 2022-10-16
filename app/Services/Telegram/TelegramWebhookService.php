<?php

namespace App\Services\Telegram;

use App\Core\DTO\FromDTO;
use App\Core\DTO\UpdateDTO;
use App\Services\User\UserCreatingService;
use App\Services\User\UserGettingService;
use App\Services\VK\VKAuthMessageCreatingService;
use Illuminate\Database\Eloquent\Model;

class TelegramWebhookService
{
    /**
     * @param VKAuthMessageCreatingService $authMessageCreatingService
     * @param UserCreatingService $userCreatingService
     * @param UserGettingService $userGettingService
     * @param MessageSendingService $messageSendingService
     */
    public function __construct(
        private VKAuthMessageCreatingService $authMessageCreatingService,
        private UserCreatingService $userCreatingService,
        private UserGettingService $userGettingService,
        private MessageSendingService $messageSendingService
    ) {
    }

    /**
     * @param UpdateDTO $update
     * @throws Client\Exception\InvalidTelegramResponseException
     */
    public function process(UpdateDTO $update)
    {
        $message = $update->getMessage() ?? $update->getCallbackQuery();

        if (!$message->isCommand()) {
            return;
        }

        $user = $this->registerUser($message->getFrom());
        if ($user->vkUser === null) {
            $this->sendOAuthMessage($update);
        }
    }

    /**
     * @param FromDTO $fromDTO
     * @return Model|null
     */
    private function registerUser(FromDTO $fromDTO): ?Model
    {
        $user = $this->userGettingService->getByUuid($fromDTO->getId());
        if ($user === null) {
            $user = $this->userCreatingService->create($fromDTO);
        }

        return $user;
    }

    /**
     * @param UpdateDTO $updateDTO
     * @throws Client\Exception\InvalidTelegramResponseException
     */
    private function sendOAuthMessage(UpdateDTO $updateDTO): void
    {
        $oauthRequestMessage = $this->authMessageCreatingService->create($updateDTO);

        $this->messageSendingService->send($oauthRequestMessage);
    }
}
