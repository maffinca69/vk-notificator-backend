<?php

namespace App\Core\Command;

use App\Core\DTO\UpdateDTO;
use App\Models\User;
use App\Services\Telegram\Client\DTO\MessageRequestDTO;
use App\Services\Telegram\Client\Exception\InvalidTelegramResponseException;
use App\Services\Telegram\MessageSendingService;
use App\Services\User\LogoutService;
use App\Services\User\UserGettingService;

final class LogoutCommand extends AbstractCommand
{
    protected string $signature = '/logout';

    public function __construct(
        private MessageSendingService $messageSendingService,
        private LogoutService $logoutService,
        private UserGettingService $userGettingService
    ) {
    }

    /**
     * @param UpdateDTO $update
     * @throws InvalidTelegramResponseException
     */
    public function handle(UpdateDTO $update): void
    {
        $message = $update->getMessage();
        $from = $message->getFrom();
        $chatId = $update->getChatId();

        $messageRequestDTO = new MessageRequestDTO($chatId);

        /** @var User $user */
        $user = $this->userGettingService->getByUuid($from->getId());
        $logout = $this->logoutService->logout($user);

        $this->sendLogoutMessage(
            $messageRequestDTO,
            $logout ? LogoutService::SUCCESSFUL_LOGOUT : LogoutService::FAILURE_LOGOUT
        );
    }

    /**
     * @param MessageRequestDTO $request
     * @param string $message
     * @throws InvalidTelegramResponseException
     */
    private function sendLogoutMessage(MessageRequestDTO $request, string $message): void
    {
        $request->setText($message);
        $this->messageSendingService->send($request);
    }

    /**
     * @param MessageRequestDTO $request
     * @throws InvalidTelegramResponseException
     */
    private function unavailableLogout(MessageRequestDTO $request): void
    {
        $request->setText(LogoutService::UNAVAILABLE_LOGOUT);
        $this->messageSendingService->send($request);
    }
}
