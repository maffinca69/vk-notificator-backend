<?php

namespace App\Services\VK\Notification;

use App\Models\User;
use App\Services\Telegram\Client\Assembler\SendMessageRequestAssembler;
use App\Services\Telegram\Client\DTO\MessageRequestDTO;
use App\Services\Telegram\Client\Exception\InvalidTelegramResponseException;
use App\Services\Telegram\Client\HttpClient;
use App\Services\VK\Notification\DTO\NotificationDTO;
use App\Services\VK\Notification\Formatter\NotificationFormatterFactory;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class NotificationSendingService
{
    /**
     * @param SendMessageRequestAssembler $sendMessageRequestAssembler
     * @param HttpClient $client
     * @param NotificationFormatterFactory $notificationFormatterFactory
     */
    public function __construct(
        private SendMessageRequestAssembler $sendMessageRequestAssembler,
        private HttpClient $client,
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
        $request = $this->sendMessageRequestAssembler->create($messageRequest);
        $this->client->sendRequest($request);
    }
}
