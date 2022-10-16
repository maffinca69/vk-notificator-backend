<?php

namespace App\Services\VK\Notification;

use App\Models\User;
use App\Services\Telegram\Client\DTO\MessageRequestDTO;
use App\Services\Telegram\Client\Exception\InvalidTelegramResponseException;
use App\Services\Telegram\MessageSendingService;
use App\Services\VK\Notification\DTO\NotificationDTO;
use App\Services\VK\Notification\Formatter\NotificationFormatterFactory;
use App\Services\VK\Notification\Formatter\ProfileLinkFormatter;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class NotificationSendingService
{
    /**
     * @param MessageSendingService $messageSendingService
     * @param NotificationFormatterFactory $notificationFormatterFactory
     * @param ProfileLinkFormatter $profileLinkFormatter
     * @param ProfileForNotificationGettingService $profileForNotificationGettingService
     * @param ProfileUrlKeyboardCreatingService $profileUrlKeyboardCreatingService
     */
    public function __construct(
        private MessageSendingService $messageSendingService,
        private NotificationFormatterFactory $notificationFormatterFactory,
        private ProfileLinkFormatter $profileLinkFormatter,
        private ProfileForNotificationGettingService $profileForNotificationGettingService,
        private ProfileUrlKeyboardCreatingService $profileUrlKeyboardCreatingService,
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

        $buttons[] = $this->appendProfileUrlButton($notificationDTO, $profiles);
        $messageRequest->setReplyMarkup([
            'inline_keyboard' => $buttons
        ]);

        $this->messageSendingService->send($messageRequest);
    }

    /**
     * @param NotificationDTO $notificationDTO
     * @param array $profiles
     * @return array
     */
    private function appendProfileUrlButton(NotificationDTO $notificationDTO, array $profiles): array
    {
        $ids = $notificationDTO->getFeedback()->getIds();
        $id = current($ids)['from_id'];

        $profile = $this->profileForNotificationGettingService->getProfile(
            $id,
            $profiles
        );
        $profileUrl = $this->profileLinkFormatter->formatUrl($profile);
        $profileName = $this->profileLinkFormatter->formatFullName($profile);

        return $this->profileUrlKeyboardCreatingService->create($profileName, $profileUrl);
    }
}
