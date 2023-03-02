<?php

namespace App\Services\VK\DTO\Attachment;

use App\Services\VK\DTO\Photo\PhotoDTO;

/**
 * @reference https://dev.vk.com/reference/objects/attachments-wall
 */
class AttachmentDTO
{
    public const PHOTO_TYPE = 'photo';
    public const POSTED_PHOTO_TYPE = 'posted_photo';
    public const VIDEO_TYPE = 'video';
    public const AUDIO_TYPE = 'audio';
    public const DOCUMENT_TYPE = 'doc';

    /**
     * @param string $type
     * @param PhotoDTO|null $photo
     */
    public function __construct(
        private string $type,
        private ?PhotoDTO $photo = null
        // etc, see reference
    ) {
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return PhotoDTO|null
     */
    public function getPhoto(): ?PhotoDTO
    {
        return $this->photo;
    }

    /**
     * @param PhotoDTO|null $photo
     */
    public function setPhoto(?PhotoDTO $photo): void
    {
        $this->photo = $photo;
    }
}
