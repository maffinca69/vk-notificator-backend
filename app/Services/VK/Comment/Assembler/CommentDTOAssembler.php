<?php

namespace App\Services\VK\Comment\Assembler;

use App\Services\VK\Assembler\Attachment\AttachmentDTOAssembler;
use App\Services\VK\DTO\Comment\CommentDTO;

class CommentDTOAssembler
{
    /**
     * @param AttachmentDTOAssembler $attachmentDTOAssembler
     */
    public function __construct(private AttachmentDTOAssembler $attachmentDTOAssembler)
    {
    }

    /**
     * @param array $params
     * @return CommentDTO|null
     * @throws \Exception
     */
    public function create(array $params): ?CommentDTO
    {
        $date = new \DateTimeImmutable(date('Y-m-d H:i:s', $params['date']));
        $attachments = [];
        foreach ($params['attachments'] ?? [] as $attachment) {
            $attachments[] = $this->attachmentDTOAssembler->create($attachment);
        }

        return new CommentDTO(
            $params['id'],
            $params['from_id'],
            $date,
            $params['text'],
            $attachments,
        );
    }
}
