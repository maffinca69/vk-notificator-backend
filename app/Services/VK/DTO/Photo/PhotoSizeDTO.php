<?php

namespace App\Services\VK\DTO\Photo;

/**
 * @reference https://dev.vk.com/reference/objects/photo-sizes
 */
class PhotoSizeDTO
{
    /**
     * @param string $url
     * @param int $width
     * @param int $height
     */
    public function __construct(
        private string $url,
        private int $width,
        private int $height,
    ) {
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }
}
