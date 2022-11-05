<?php

namespace App\Core\Command;

use App\Core\DTO\UpdateDTO;
use App\Models\User;
use App\Services\Telegram\Client\DTO\MessageRequestDTO;
use App\Services\Telegram\Client\Exception\InvalidTelegramResponseException;
use App\Services\Telegram\MessageSendingService;
use App\Services\User\LogoutService;

final class LogoutCommand extends AbstractCommand
{
    protected string $signature = '/logout';

    public function __construct(
        private MessageSendingService $messageSendingService,
        private LogoutService $logoutService
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

        $messageRequestDTO = new MessageRequestDTO($update->getChatId());

        $user = User::query()->where(['uuid' => $from->getId()])->first();
        if ($user === null) {
            $messageRequestDTO->setText(LogoutService::UNAVAILABLE_LOGOUT);
            $this->messageSendingService->send($messageRequestDTO);
            return;
        }

        /** @var User $user */
        $logout = $this->logoutService->logout($user);
        if (!$logout) {
            $messageRequestDTO->setText(LogoutService::FAILURE_LOGOUT);
        }

        $messageRequestDTO->setText(LogoutService::SUCCESSFUL_LOGOUT);
        $this->messageSendingService->send($messageRequestDTO);
    }
}
