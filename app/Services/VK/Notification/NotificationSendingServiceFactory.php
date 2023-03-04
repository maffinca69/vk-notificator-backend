<?php

namespace App\Services\VK\Notification;

use App\Services\VK\Notification\DTO\NotificationDTO;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class NotificationSendingServiceFactory
{
    public function __construct(
        private ContainerInterface $container,
        private NotificationAttachmentsGettingService $notificationAttachmentsGettingService
    ) {
    }

    /**
     * @param NotificationDTO $notificationDTO
     * @return NotificationSendingInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function create(NotificationDTO $notificationDTO): NotificationSendingInterface
    {
        $attachments = $this->notificationAttachmentsGettingService->get($notificationDTO);

        if (!empty($attachments)) {
            return $this->container->get(NotificationWithAttachmentsSendingService::class);
        }

        return $this->container->get(NotificationSendingService::class);
    }
}
