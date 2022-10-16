<?php

namespace App\Services\VK\Notification;

use App\Models\User;
use App\Services\Telegram\Client\DTO\MessageRequestDTO;
use App\Services\Telegram\Client\Exception\InvalidTelegramResponseException;
use App\Services\Telegram\MessageSendingService;
use App\Services\VK\Notification\DTO\NotificationDTO;
use App\Services\VK\Notification\Formatter\NotificationFormatterFactory;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class NotificationSendingService
{
    /**
     * @param MessageSendingService $messageSendingService
     * @param NotificationFormatterFactory $notificationFormatterFactory
     */
    public function __construct(
        private MessageSendingService $messageSendingService,
        private NotificationFormatterFactory $notificationFormatterFactory
    ) {
    }

    /**
     * @param User $user
     * @param NotificationDTO $notificationDTO
     * @param array $profiles
     * @param array $groups
     * @return void
     * @throws InvalidTelegramResponseException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function send(User $user, NotificationDTO $notificationDTO, array $profiles, array $groups): void
    {
        $notification = $this->notificationFormatterFactory->create($notificationDTO);
        $message = $notification->format($notificationDTO, $profiles, $groups);

        $messageRequest = new MessageRequestDTO($user->uuid);
        $messageRequest->setText($message);
        $messageRequest->setParseMode(MessageRequestDTO::PARSE_MODE_MARKDOWN);
        $messageRequest->setDisableWebPagePreview(true);

        $this->messageSendingService->send($messageRequest);
    }
}
