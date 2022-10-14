<?php

namespace App\Http\Request\Assembler\Telegram\Message;

use App\Core\DTO\StickerThumbDTO;

class MessageStickerThumbAssembler
{
    /**
     * @param array $params
     * @return StickerThumbDTO
     */
    public function create(array $params): StickerThumbDTO
    {
        $stickerThumbDTO = new StickerThumbDTO();
        $stickerThumbDTO->setFileId($params['file_id'])
            ->setFileSize($params['file_size'])
            ->setFileUniqueId($params['file_unique_id'])
            ->setHeight($params['height'])
            ->setWidth($params['width']);

        return $stickerThumbDTO;
    }
}
