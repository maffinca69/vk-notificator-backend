<?php

namespace App\Services\VK\Notification;

use App\Infrastructure\Telegram\Client\Exception\TelegramHttpClientException;
use App\Models\User;
use App\Services\Telegram\DTO\MessageRequestDTO;
use App\Services\Telegram\MessageSendingService;
use App\Services\VK\DTO\Notification\NotificationDTO;
use App\Services\VK\DTO\Notification\NotificationResponseDTO;
use App\Services\VK\Notification\Formatter\NotificationFormatterFactory;
use App\Services\VK\Notification\Keyboard\ReplyMarkupCreatingService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class NotificationSendingService implements NotificationSendingInterface
{
    /**
     * @param MessageSendingService $messageSendingService
     * @param NotificationFormatterFactory $notificationFormatterFactory
     * @param ReplyMarkupCreatingService $replyMarkupCreatingService
     */
    public function __construct(
        private MessageSendingService $messageSendingService,
        private NotificationFormatterFactory $notificationFormatterFactory,
        private ReplyMarkupCreatingService $replyMarkupCreatingService
    ) {
    }

    /**
     * @param NotificationResponseDTO $response
     * @param NotificationDTO $notification
     * @param User $recipient
     * @return void
     * @throws ContainerExceptionInterface
     * @throws TelegramHttpClientException
     * @throws NotFoundExceptionInterface
     */
    public function send(NotificationResponseDTO $response, NotificationDTO $notification, User $recipient): void
    {
        $profiles = $response->getProfiles();
        $groups = $response->getGroups();

        $notificationFormatter = $this->notificationFormatterFactory->create($notification);
        $message = $notificationFormatter->format($notification, $profiles, $groups);

        $replyMarkup = $this->replyMarkupCreatingService->create($notification);
        $messageRequest = new MessageRequestDTO(
            chatId: $recipient->getUuid(),
            text: $message,
            parseMode: MessageRequestDTO::PARSE_MODE_MARKDOWN,
            replyMarkup: $replyMarkup,
            disableWebPagePreview: true
        );

        $this->messageSendingService->send($messageRequest);
    }
}
