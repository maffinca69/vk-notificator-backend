<?php

namespace App\Services\VK\Notification\DTO;

class NotificationParentSizeDTO
{
    private int $height;
    private int $width;
    private string $url;
    private string $type;

    /**
     * @param int $height
     * @param int $width
     * @param string $url
     * @param string $type
     */
    public function __construct(
        int $height,
        int $width,
        string $url,
        string $type
    ) {
        $this->height = $height;
        $this->width = $width;
        $this->url = $url;
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}
