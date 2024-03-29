<?php

namespace App\Services\VK\Notification\Attachment;

use App\Infrastructure\Logger\NotificationMailingLogger;
use App\Infrastructure\VK\Client\Exception\VKAPIHttpClientException;
use App\Models\VKUser;
use App\Services\VK\Comment\CommentGettingService;
use App\Services\VK\DTO\Notification\NotificationDTO;
use App\Services\VK\Notification\Dictionary\NotificationTypesDictionary;
use App\Services\VK\Post\PostsGettingService;

class NotificationAttachmentsAssigningService
{
    public function __construct(
        private CommentGettingService $commentGettingService,
        private PostsGettingService $postsGettingService,
        private NotificationMailingLogger $logger
    ) {
    }

    /**
     * @param VKUser $VKUser
     * @param NotificationDTO $notification
     * @return void
     * @throws VKAPIHttpClientException
     */
    public function assign(VKUser $VKUser, NotificationDTO $notification): void
    {
        match ($notification->getType()) {
            NotificationTypesDictionary::LIKE_COMMENT_PHOTO_TYPE,
            NotificationTypesDictionary::LIKE_COMMENT_VIDEO_TYPE,
            NotificationTypesDictionary::LIKE_COMMENT_TYPE => $this->assignCommentAttachments($VKUser, $notification),
            NotificationTypesDictionary::WALL_PUBLISH_TYPE => $this->assignPostAttachments($VKUser, $notification),
            default => $this->logger->warning('Not implement yet type', [
                'type' => $notification->getType()
            ])
        };
    }

    /**
     * @param VKUser $VKUser
     * @param NotificationDTO $notification
     * @return void
     * @throws VKAPIHttpClientException
     */
    private function assignPostAttachments(VKUser $VKUser, NotificationDTO $notification): void
    {
        $feedback = $notification->getFeedback();
        $id = $feedback->getId();
        $ownerId = $feedback->getOwnerId();

        $posts = $this->postsGettingService->get($VKUser, [$ownerId . '_' . $id]);
        if (empty($posts)) {
            return;
        }

        $post = reset($posts);
        $notification->setPostAttachments($post->getAttachments());
    }

    /**
     * @param VKUser $VKUser
     * @param NotificationDTO $notification
     * @return void
     * @throws VKAPIHttpClientException
     */
    private function assignCommentAttachments(VKUser $VKUser, NotificationDTO $notification): void
    {
        $post = $notification->getParent()?->getPost();
        $commentId = $notification->getParent()?->getId();

        $ownerId = $post?->getFromId();
        $postId = $post?->getId();

        if (!isset($ownerId, $postId, $commentId)) {
            return;
        }

        $comment = $this->commentGettingService->get($VKUser, $ownerId, $postId, $commentId);
        $notification->setCommentAttachments($comment?->getAttachments() ?? []);
    }
}
