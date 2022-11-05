<?php

namespace App\Core\Command;

use App\Core\DTO\UpdateDTO;
use App\Models\User;
use App\Services\Telegram\Client\DTO\MessageRequestDTO;
use App\Services\Telegram\Client\Exception\InvalidTelegramResponseException;
use App\Services\Telegram\MessageSendingService;
use App\Services\User\UserRegisteringService;
use App\Services\VK\VKAuthMessageCreatingService;

final class StartCommand extends AbstractCommand
{
    protected string $signature = '/start';

    public function __construct(
        private UserRegisteringService $userRegisteringService,
        private VKAuthMessageCreatingService $authMessageCreatingService,
        private MessageSendingService $messageSendingService,
    ) {
    }

    /**
     * @param UpdateDTO $update
     *
     * @return void
     * @throws InvalidTelegramResponseException
     */
    public function handle(UpdateDTO $update): void
    {
        $message = $update->getMessage();

        /** @var User $user */
        $user = $this->userRegisteringService->register($message->getFrom());
        if ($user->getVKUser() === null) {
            $this->sendOAuthMessage($update);
            return;
        }

        $request = new MessageRequestDTO($update->getChatId());
        $request->setText($message->getText() ?? 'Hmm...');
        $this->messageSendingService->send($request);
    }

    /**
     * @param UpdateDTO $updateDTO
     * @throws InvalidTelegramResponseException
     */
    private function sendOAuthMessage(UpdateDTO $updateDTO): void
    {
        $oauthRequestMessage = $this->authMessageCreatingService->create($updateDTO);

        $this->messageSendingService->send($oauthRequestMessage);
    }
}
