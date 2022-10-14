<?php

namespace App\Services\Telegram;

use App\Core\DTO\FromDTO;
use App\Core\DTO\UpdateDTO;
use App\Services\Telegram\Client\Assembler\SendMessageRequestAssembler;
use App\Services\Telegram\Client\HttpClient;
use App\Services\User\UserCreatingService;
use App\Services\User\UserGettingService;
use App\Services\VK\VKAuthMessageCreatingService;
use Illuminate\Database\Eloquent\Model;

class TelegramWebhookService
{
    /**
     * @param VKAuthMessageCreatingService $authMessageCreatingService
     * @param HttpClient $client
     * @param SendMessageRequestAssembler $sendMessageRequestAssembler
     * @param UserCreatingService $userCreatingService
     * @param UserGettingService $userGettingService
     */
    public function __construct(
        private VKAuthMessageCreatingService $authMessageCreatingService,
        private HttpClient $client,
        private SendMessageRequestAssembler $sendMessageRequestAssembler,
        private UserCreatingService $userCreatingService,
        private UserGettingService $userGettingService
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
        $request = $this->sendMessageRequestAssembler->create($oauthRequestMessage);
        $this->client->sendRequest($request);
    }
}
