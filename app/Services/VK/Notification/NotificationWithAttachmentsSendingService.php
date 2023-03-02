<?php

namespace App\Services\VK\Notification;

use App\Core\DTO\PhotoDTO;
use App\Models\User;
use App\Services\Telegram\Client\Exception\InvalidTelegramResponseException;
use App\Services\Telegram\DTO\InputMedia\AbstractInputMedia;
use App\Services\Telegram\DTO\InputMedia\InputMediaPhotoDTO;
use App\Services\Telegram\DTO\MediaGroupRequestDTO;
use App\Services\Telegram\DTO\MessageRequestDTO;
use App\Services\Telegram\MediaGroupMessageSendingService;
use App\Services\Telegram\MessageSendingService;
use App\Services\VK\DTO\Attachment\AttachmentDTO;
use App\Services\VK\Notification\DTO\NotificationDTO;
use App\Services\VK\Notification\DTO\NotificationParentDTO;
use App\Services\VK\Notification\DTO\NotificationResponseDTO;
use App\Services\VK\Notification\Formatter\Link\WallReplyLinkFormatter;
use App\Services\VK\Notification\Formatter\NotificationFormatterFactory;
use App\Services\VK\Notification\Keyboard\UrlButtonCreatingService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class NotificationWithAttachmentsSendingService implements NotificationSendingInterface
{
    public const NOTIFICATION_PAGE_URL = 'https://vk.com/feed?section=notifications';

    /**
     * @param MediaGroupMessageSendingService $mediaGroupMessageSendingService
     * @param NotificationFormatterFactory $notificationFormatterFactory
     * @param UrlButtonCreatingService $urlButtonCreatingService
     * @param WallReplyLinkFormatter $wallReplyLinkFormatter
     */
    public function __construct(
        private MediaGroupMessageSendingService $mediaGroupMessageSendingService,
        private NotificationFormatterFactory $notificationFormatterFactory,
        private UrlButtonCreatingService $urlButtonCreatingService,
        private WallReplyLinkFormatter $wallReplyLinkFormatter,
    ) {
    }

    /**
     * @param NotificationResponseDTO $response
     * @param NotificationDTO $notification
     * @param User $recipient
     * @return void
     * @throws ContainerExceptionInterface
     * @throws InvalidTelegramResponseException
     * @throws NotFoundExceptionInterface
     */
    public function send(NotificationResponseDTO $response, NotificationDTO $notification, User $recipient): void
    {
        $profiles = $response->getProfiles();
        $groups = $response->getGroups();

        $notificationFormatter = $this->notificationFormatterFactory->create($notification);
        $message = $notificationFormatter->format($notification, $profiles, $groups);

        $attachments = $notification->getParent()?->getPost()?->getAttachments() ?: [];

        $media = $this->getMedia($attachments, $message);

        $messageRequest = new MediaGroupRequestDTO(
            $recipient->getUuid(),
            $media
        );
        $messageRequest->setParseMode(MessageRequestDTO::PARSE_MODE_MARKDOWN);

        $buttons[] = $this->appendNotificationUrlButton();

        $parent = $notification->getParent();
        $buttons[] = $parent ? $this->appendReplyUrlButton($parent) : [];

        $messageRequest->setReplyMarkup([
            'inline_keyboard' => array_filter($buttons)
        ]);

        $this->mediaGroupMessageSendingService->send($messageRequest);
    }

    /**
     * @param array<AttachmentDTO> $attachments
     * @return array<AbstractInputMedia>
     */
    private function getMedia(array $attachments, string $caption): array
    {
        $media = [];

        foreach ($attachments as $attachment) {
            $photo = $attachment->getPhoto();
            if ($photo !== null) {
                $photoSizes = $photo->getSizes() ?: [];
                $maxSize = end($photoSizes);
                $media[] = new InputMediaPhotoDTO(
                    $maxSize->getUrl(),
                    empty($media) ? $caption : null
                );
            }
        }

        return $media;
    }

    /**
     * @return array
     */
    private function appendNotificationUrlButton(): array
    {
        return $this->urlButtonCreatingService->create('Открыть уведомления', self::NOTIFICATION_PAGE_URL);
    }

    /**
     * @param NotificationParentDTO $parent
     * @return array
     */
    private function appendReplyUrlButton(NotificationParentDTO $parent): array
    {
        $url = $this->wallReplyLinkFormatter->format($parent);
        return $this->urlButtonCreatingService->create('Открыть пост', $url);
    }
}