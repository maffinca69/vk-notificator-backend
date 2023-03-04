<?php

namespace App\Services\VK\Notification\Assembler;

use App\Services\VK\Assembler\Attachment\AttachmentDTOAssembler;
use App\Services\VK\Comment\CommentGettingService;
use App\Services\VK\Notification\DTO\NotificationDTO;
use App\Services\VK\Notification\DTO\NotificationFeedbackDTO;
use App\Services\VK\Notification\DTO\NotificationParentDTO;
use App\Services\VK\Notification\DTO\NotificationParentPostDTO;
use App\Services\VK\Notification\DTO\NotificationParentSizeDTO;

class NotificationDTOAssembler
{
    public function __construct(private AttachmentDTOAssembler $attachmentDTOAssembler)
    {
    }

    /**
     * @param array $params
     * @return NotificationDTO
     * @throws \Exception
     */
    public function create(array $params): NotificationDTO
    {
        $feedback = $this->createFeedback($params['feedback']);

        $date = new \DateTime(date('Y-m-d H:i:s', $params['date']));

        $notification = new NotificationDTO(
            $params['type'],
            $date,
            $feedback
        );

        if (isset($params['parent'])) {
            $parent = $this->createParent($params['parent']);
            $notification->setParent($parent);
        }

        return $notification;
    }

    private function createParent(array $params): NotificationParentDTO
    {
        $parent = new NotificationParentDTO($params['id']);

        if (isset($params['text'])) {
            $parent->setText($params['text']);
        }

        if (isset($params['owner_id'])) {
            $parent->setOwnerId($params['owner_id']);
        }

        if (isset($params['date'])) {
            $parent->setDate(new \DateTime(date('Y-m-d H:i:s', $params['date'])));
        }

        if (isset($params['post'])) {
            $post = $this->createPost($params['post']);
            $parent->setPost($post);
        }

        if (isset($params['sizes'])) {
            $sizes = [];
            foreach ($params['sizes'] as $size) {
                $sizes[] = $this->createSize($size);
            }

            $parent->setSizes($sizes);
        }

        return $parent;
    }

    /**
     * @param array $params
     * @return NotificationParentSizeDTO
     */
    private function createSize(array $params): NotificationParentSizeDTO
    {
        return new NotificationParentSizeDTO(
            $params['height'],
            $params['width'],
            $params['url'],
            $params['type'],
        );
    }

    /**
     * @param array $params
     * @return NotificationParentPostDTO
     * @throws \Exception
     */
    private function createPost(array $params): NotificationParentPostDTO
    {
        $post = new NotificationParentPostDTO($params['id']);

        if (isset($params['from_id'])) {
            $post->setFromId($params['from_id']);
        }

        if (isset($params['to_id'])) {
            $post->setToId($params['to_id']);
        }

        if (isset($params['date'])) {
            $post->setDate(new \DateTime(date('Y-m-d H:i:s', $params['date'])));
        }

        if (isset($params['is_favorite'])) {
            $post->setIsFavorite($params['is_favorite']);
        }

        if (isset($params['post_type'])) {
            $post->setPostType($params['post_type']);
        }

        if (isset($params['text'])) {
            $post->setText($params['text']);
        }

        if (isset($params['signer_id'])) {
            $post->setSingerId($params['signer_id']);
        }

        if (isset($params['short_text_date'])) {
            $post->setShortTextRate($params['short_text_date']);
        }

        $attachments = $params['attachments'] ?: [];
        foreach ($attachments as $attachment) {
            $attachment = $this->attachmentDTOAssembler->create($attachment);
            $post->addAttachment($attachment);
        }

        return $post;
    }

    /**
     * @todo переписать, т.к собирать нужно в зависимости от типа уведомления
     *
     * @param array $params
     * @return NotificationFeedbackDTO
     */
    private function createFeedback(array $params): NotificationFeedbackDTO
    {
        $ids = [];
        $items = $params['items'] ?? [];
        foreach ($items as $key => $item) {
            $ids[$key] = $item;
        }

        $feedback = new NotificationFeedbackDTO($params['count'] ?? 1, $ids);

        if (isset($params['from_id'])) {
            $feedback->setFromId($params['from_id']);
        }

        if (isset($params['id'])) {
            $feedback->setId($params['id']);
        }

        if (isset($params['text'])) {
            $feedback->setText($params['text']);
        }

        return $feedback;
    }
}
