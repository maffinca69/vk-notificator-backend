<?php

namespace App\Services\Telegram\DTO;

class StickerDTO
{
    private int $width;

    private int $height;

    private string $emoji;

    private string $set_name;

    private bool $isAnimated = false;

    private bool $isVideo = false;

    private StickerThumbDTO $stickerThumbDTO;

    private string $fileId;

    private string $fileUniqueId;

    private int $fileSize;

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @param int $width
     * @return StickerDTO
     */
    public function setWidth(int $width): StickerDTO
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
     * @return StickerDTO
     */
    public function setHeight(int $height): StickerDTO
    {
        $this->height = $height;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmoji(): string
    {
        return $this->emoji;
    }

    /**
     * @param string $emoji
     * @return StickerDTO
     */
    public function setEmoji(string $emoji): StickerDTO
    {
        $this->emoji = $emoji;

        return $this;
    }

    /**
     * @return string
     */
    public function getSetName(): string
    {
        return $this->set_name;
    }

    /**
     * @param string $set_name
     * @return StickerDTO
     */
    public function setSetName(string $set_name): StickerDTO
    {
        $this->set_name = $set_name;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAnimated(): bool
    {
        return $this->isAnimated;
    }

    /**
     * @param bool $isAnimated
     * @return StickerDTO
     */
    public function setIsAnimated(bool $isAnimated): StickerDTO
    {
        $this->isAnimated = $isAnimated;

        return $this;
    }

    /**
     * @return bool
     */
    public function isVideo(): bool
    {
        return $this->isVideo;
    }

    /**
     * @param bool $isVideo
     * @return StickerDTO
     */
    public function setIsVideo(bool $isVideo): StickerDTO
    {
        $this->isVideo = $isVideo;

        return $this;
    }

    /**
     * @return StickerThumbDTO
     */
    public function getStickerThumbDTO(): StickerThumbDTO
    {
        return $this->stickerThumbDTO;
    }

    /**
     * @param StickerThumbDTO $stickerThumbDTO
     * @return StickerDTO
     */
    public function setStickerThumbDTO(StickerThumbDTO $stickerThumbDTO): StickerDTO
    {
        $this->stickerThumbDTO = $stickerThumbDTO;

        return $this;
    }

    /**
     * @return string
     */
    public function getFileId(): string
    {
        return $this->fileId;
    }

    /**
     * @param string $fileId
     * @return StickerDTO
     */
    public function setFileId(string $fileId): StickerDTO
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
     * @return StickerDTO
     */
    public function setFileUniqueId(string $fileUniqueId): StickerDTO
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
     * @return StickerDTO
     */
    public function setFileSize(int $fileSize): StickerDTO
    {
        $this->fileSize = $fileSize;

        return $this;
    }
}
