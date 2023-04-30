<?php

namespace App\Services\VK\Notification\Send;

use App\Services\VK\DTO\Notification\NotificationDTO;
use App\Services\VK\Notification\Specification\HasAttachmentsSpecification;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class NotificationSendingServiceFactory
{
    public function __construct(
        private ContainerInterface $container,
        private HasAttachmentsSpecification $hasAttachmentsSpecification
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
        $hasAttachments = $this->hasAttachmentsSpecification->isSatisfiedBy($notificationDTO);
        if ($hasAttachments) {
            return $this->container->get(NotificationWithAttachmentsSendingService::class);
        }

        return $this->container->get(NotificationSendingService::class);
    }
}
