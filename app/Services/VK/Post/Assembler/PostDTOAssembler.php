<?php

namespace App\Services\VK\Post\Assembler;

use App\Services\VK\Assembler\Attachment\AttachmentDTOAssembler;
use App\Services\VK\DTO\Post\PostDTO;

class PostDTOAssembler
{
    public function __construct(private AttachmentDTOAssembler $attachmentDTOAssembler)
    {
    }

    /**
     * @param array $params
     * @return PostDTO
     * @throws \Exception
     */
    public function create(array $params): PostDTO
    {
        if (!isset($params['id'])) {
            throw new \InvalidArgumentException('ID is missing');
        }

        $date = new \DateTimeImmutable(date('Y-m-d H:i:s', $params['date']));
        $attachments = [];
        if (isset($params['attachments'])) {
            foreach ($params['attachments'] as $attachment) {
                $attachments[] = $this->attachmentDTOAssembler->create($attachment);
            }
        }

        return new PostDTO(
            $params['id'],
            $params['owner_id'],
            $date,
            $params['text'],
            $attachments
        );
    }
}
