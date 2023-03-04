<?php

namespace App\Http\Request\Assembler\Telegram\Message;

use App\Services\Telegram\DTO\StickerDTO;

class MessageStickerAssembler
{
    private MessageStickerThumbAssembler $messageStickerThumbAssembler;

    public function __construct(MessageStickerThumbAssembler $messageStickerThumbAssembler)
    {
        $this->messageStickerThumbAssembler = $messageStickerThumbAssembler;
    }

    /**
     * @param array $params
     * @return StickerDTO|null
     */
    public function create(array $params): ?StickerDTO
    {
        if (!isset($params['sticker'])) {
            return null;
        }

        $sticker = $params['sticker'];
        $thumb = $this->messageStickerThumbAssembler->create($sticker['thumb']);

        $stickerDTO = new StickerDTO();
        $stickerDTO->setWidth($sticker['width'])
            ->setHeight($sticker['height'])
            ->setFileUniqueId($sticker['file_unique_id'])
            ->setFileSize($sticker['file_size'])
            ->setFileId($sticker['file_id'])
            ->setEmoji($sticker['emoji'])
            ->setIsVideo($sticker['is_video'])
            ->setSetName($sticker['set_name'])
            ->setIsAnimated($sticker['is_animated'])
            ->setStickerThumbDTO($thumb);

        return $stickerDTO;
    }
}
