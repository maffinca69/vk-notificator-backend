<?php

namespace App\Services\Telegram\Command;

use App\Domain\Service\User\LogoutService;
use App\Domain\Service\User\UserGettingService;
use App\Infrastructure\Telegram\Client\Exception\TelegramHttpClientException;
use App\Models\User;
use App\Services\Telegram\DTO\Request\MessageRequestDTO;
use App\Services\Telegram\DTO\UpdateDTO;
use App\Services\Telegram\MessageSendingService;

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
     * @throws TelegramHttpClientException
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
     * @throws TelegramHttpClientException
     */
    private function sendLogoutMessage(MessageRequestDTO $request, string $message): void
    {
        $request->setText($message);
        $this->messageSendingService->send($request);
    }
}
