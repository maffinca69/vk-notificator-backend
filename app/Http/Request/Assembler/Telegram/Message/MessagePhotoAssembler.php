<?php

namespace App\Http\Request\Assembler\Telegram\Message;

use App\Services\Telegram\DTO\PhotoDTO;

class MessagePhotoAssembler
{
    public function create(?array $params): ?PhotoDTO
    {
        if (!$params) {
            return null;
        }

        $params = end($params); // best quality photo obj

        $photo = new PhotoDTO();
        $photo->setFileId($params['file_id']);
        $photo->setFileSize($params['file_size']);
        $photo->setFileUniqueId($params['file_unique_id']);
        $photo->setWidth($params['width']);
        $photo->setHeight($params['height']);

        return $photo;
    }
}
