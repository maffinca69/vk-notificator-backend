<?php

namespace App\Services\VK\Notification;

use App\Infrastructure\Telegram\Client\Exception\TelegramHttpClientException;
use App\Models\User;
use App\Services\Telegram\DTO\InputMedia\AbstractInputMedia;
use App\Services\Telegram\DTO\InputMedia\InputMediaPhotoDTO;
use App\Services\Telegram\DTO\Request\MessageRequestDTO;
use App\Services\Telegram\DTO\Request\SendPhotoRequestDTO;
use App\Services\Telegram\PhotoSendingService;
use App\Services\VK\DTO\Attachment\AttachmentDTO;
use App\Services\VK\DTO\Notification\NotificationDTO;
use App\Services\VK\DTO\Notification\NotificationResponseDTO;
use App\Services\VK\Notification\Attachment\NotificationAttachmentsGettingService;
use App\Services\VK\Notification\Attachment\Translator\InputMediaTranslator;
use App\Services\VK\Notification\Formatter\NotificationFormatterFactory;
use App\Services\VK\Notification\Keyboard\ReplyMarkupCreatingService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class NotificationWithAttachmentsSendingService implements NotificationSendingInterface
{
    /**
     * @param PhotoSendingService $photoSendingService
     * @param NotificationFormatterFactory $notificationFormatterFactory
     * @param ReplyMarkupCreatingService $replyMarkupCreatingService
     * @param NotificationAttachmentsGettingService $notificationAttachmentsGettingService
     * @param InputMediaTranslator $inputMediaTranslator
     */
    public function __construct(
        private PhotoSendingService $photoSendingService,
        private NotificationFormatterFactory $notificationFormatterFactory,
        private ReplyMarkupCreatingService $replyMarkupCreatingService,
        private NotificationAttachmentsGettingService $notificationAttachmentsGettingService,
        private InputMediaTranslator $inputMediaTranslator
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

        $attachments = $this->notificationAttachmentsGettingService->get($notification);
        $medias = $this->inputMediaTranslator->translate($attachments);

        /** @var AbstractInputMedia $media */
        $media = reset($medias);
        $media->setCaption($message);

        $replyMarkup = $this->replyMarkupCreatingService->create($notification);
        $photoRequestDTO = new SendPhotoRequestDTO(
            $recipient->getUuid(),
            $media->getMedia(),
            $message,
            $replyMarkup,
            MessageRequestDTO::PARSE_MODE_MARKDOWN
        );

        $this->photoSendingService->send($photoRequestDTO);
    }
}
