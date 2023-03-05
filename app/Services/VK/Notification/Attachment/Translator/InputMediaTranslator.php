<?php

namespace App\Services\VK\Notification\Attachment\Translator;

use App\Services\Telegram\DTO\InputMedia\AbstractInputMedia;
use App\Services\Telegram\DTO\InputMedia\InputMediaPhotoDTO;
use App\Services\VK\DTO\Attachment\AttachmentDTO;
use App\Services\VK\DTO\Photo\PhotoDTO;

class InputMediaTranslator
{
    /**
     * @param array<AttachmentDTO> $attachments
     * @return array<AbstractInputMedia>
     */
    public function translate(array $attachments): array
    {
        $media = [];

        foreach ($attachments as $attachment) {
            $photo = $attachment->getPhoto();
            if (isset($photo)) {
                $media[] = $this->createInputMediaPhoto($photo);
            }
        }

        return $media;
    }

    /**
     * @param PhotoDTO $photo
     * @return InputMediaPhotoDTO
     */
    private function createInputMediaPhoto(PhotoDTO $photo): InputMediaPhotoDTO
    {
        $photoSizes = $photo->getSizes() ?: [];
        $maxSize = end($photoSizes);

        return new InputMediaPhotoDTO($maxSize->getUrl());
    }
}
