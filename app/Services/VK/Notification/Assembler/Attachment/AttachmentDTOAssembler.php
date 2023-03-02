<?php

namespace App\Services\VK\Notification\Assembler\Attachment;

use App\Services\VK\DTO\Attachment\AttachmentDTO;

class AttachmentDTOAssembler
{
    public function __construct(
        private PhotoDTOAttachmentAssembler $photoDTOAttachmentAssembler
    ) {
    }

    /**
     * @param array $params
     * @return AttachmentDTO
     */
    public function create(array $params): AttachmentDTO
    {
        $type = $params['type'];
        $attachment = new AttachmentDTO($type);

        if ($type === AttachmentDTO::PHOTO_TYPE) {
            $photo = $this->photoDTOAttachmentAssembler->create($params['photo']);
            $attachment->setPhoto($photo);
        }

        return $attachment;
    }
}
