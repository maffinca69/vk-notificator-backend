<?php

namespace App\Services\Telegram\Hydrator;

use App\Services\Telegram\DTO\InputMedia\InputMediaPhotoDTO;

class InputMediaPhotoDTOHydrator
{
    /**
     * @param InputMediaPhotoDTO $inputMediaPhoto
     * @return array
     */
    public function extract(InputMediaPhotoDTO $inputMediaPhoto): array
    {
        $params = [
            'type' => $inputMediaPhoto->getType(),
            'media' => $inputMediaPhoto->getMedia(),
        ];

        if (!empty($inputMediaPhoto->getCaption())) {
            $params['caption'] = $inputMediaPhoto->getCaption();
        }

        return $params;
    }
}
