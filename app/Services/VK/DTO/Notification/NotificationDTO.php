<?php

namespace App\Services\VK\DTO\Notification;

class NotificationDTO
{
    private string $type;
    private \DateTimeInterface $date;
    private ?NotificationParentDTO $parent = null;
    private NotificationFeedbackDTO $feedback;
    private array $commentAttachments = [];

    /**
     * @param string $type
     * @param \DateTimeInterface $date
     * @param NotificationFeedbackDTO $feedback
     */
    public function __construct(
        string $type,
        \DateTimeInterface $date,
        NotificationFeedbackDTO $feedback
    ) {
        $this->type = $type;
        $this->date = $date;
        $this->feedback = $feedback;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @return NotificationParentDTO|null
     */
    public function getParent(): ?NotificationParentDTO
    {
        return $this->parent;
    }

    /**
     * @return NotificationFeedbackDTO
     */
    public function getFeedback(): NotificationFeedbackDTO
    {
        return $this->feedback;
    }

    /**
     * @param NotificationParentDTO|null $parent
     */
    public function setParent(?NotificationParentDTO $parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @return array
     */
    public function getCommentAttachments(): array
    {
        return $this->commentAttachments;
    }

    /**
     * @param array $commentAttachments
     */
    public function setCommentAttachments(array $commentAttachments): void
    {
        $this->commentAttachments = $commentAttachments;
    }
}
