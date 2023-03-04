<?php

namespace App\Services\Telegram\DTO;

class StickerThumbDTO
{

    private string $fileId;

    private string $fileUniqueId;

    private int $fileSize;

    private int $width;

    private int $height;

    /**
     * @return string
     */
    public function getFileId(): string
    {
        return $this->fileId;
    }

    /**
     * @param string $fileId
     * @return StickerThumbDTO
     */
    public function setFileId(string $fileId): StickerThumbDTO
    {
        $this->fileId = $fileId;

        return $this;
    }

    /**
     * @return string
     */
    public function getFileUniqueId(): string
    {
        return $this->fileUniqueId;
    }

    /**
     * @param string $fileUniqueId
     * @return StickerThumbDTO
     */
    public function setFileUniqueId(string $fileUniqueId): StickerThumbDTO
    {
        $this->fileUniqueId = $fileUniqueId;

        return $this;
    }

    /**
     * @return int
     */
    public function getFileSize(): int
    {
        return $this->fileSize;
    }

    /**
     * @param int $fileSize
     * @return StickerThumbDTO
     */
    public function setFileSize(int $fileSize): StickerThumbDTO
    {
        $this->fileSize = $fileSize;

        return $this;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @param int $width
     * @return StickerThumbDTO
     */
    public function setWidth(int $width): StickerThumbDTO
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @param int $height
     * @return StickerThumbDTO
     */
    public function setHeight(int $height): StickerThumbDTO
    {
        $this->height = $height;

        return $this;
    }
}
