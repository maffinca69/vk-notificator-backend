<?php

namespace App\Services\Telegram\DTO\InputMedia;

class InputMediaPhotoDTO extends AbstractInputMedia
{
    public const TYPE = 'photo';

    /**
     * @param string $media
     * @param string|null $caption
     */
    public function __construct(string $media, ?string $caption = null)
    {
        parent::__construct(self::TYPE, $media, $caption);
    }
}
