<?php

namespace App\Services\VK\Assembler\Attachment;

use App\Services\VK\DTO\Photo\PhotoDTO;
use App\Services\VK\DTO\Photo\PhotoSizeDTO;

class PhotoDTOAttachmentAssembler
{
    /**
     * @param array $params
     * @return PhotoDTO
     * @throws \Exception
     */
    public function create(array $params): PhotoDTO
    {
        $date = new \DateTimeImmutable(date('Y-m-d H:i:s', $params['date']));

        $sizes = $this->getSizes($params['sizes']);

        return new PhotoDTO(
            $params['id'],
            $params['album_id'],
            $params['user_id'],
            $params['text'],
            $date,
            $sizes,
        );
    }

    /**
     * @param array $sizes
     * @return array
     */
    public function getSizes(array $sizes): array
    {
        $sizesDTO = [];

        foreach ($sizes as $size) {
            $sizesDTO[] = new PhotoSizeDTO(
                $size['url'],
                $size['width'],
                $size['height'],
            );
        }

        return $sizesDTO;
    }
}
