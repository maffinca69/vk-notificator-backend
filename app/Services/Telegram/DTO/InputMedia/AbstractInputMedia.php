<?php

namespace App\Services\Telegram\DTO\InputMedia;

abstract class AbstractInputMedia
{
    /**
     * @param string $type
     * @param string $media
     * @param string|null $caption
     */
    public function __construct(
        private string $type,
        private string $media,
        private ?string $caption = null
    ) {
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getMedia(): string
    {
        return $this->media;
    }

    /**
     * @return string|null
     */
    public function getCaption(): ?string
    {
        return $this->caption;
    }
}
