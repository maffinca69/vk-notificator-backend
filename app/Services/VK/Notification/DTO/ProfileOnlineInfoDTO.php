<?php

namespace App\Services\VK\Notification\DTO;

class ProfileOnlineInfoDTO
{
    private int $visible;
    private ?\DateTimeInterface $lastSeen;
    private ?bool $isOnline;
    private ?bool $isMobile;
    private ?string $status;

    /**
     * @param int $visible
     */
    public function __construct(int $visible)
    {
        $this->visible = $visible;
    }

    /**
     * @return int
     */
    public function getVisible(): int
    {
        return $this->visible;
    }



    /**
     * @return \DateTimeInterface|null
     */
    public function getLastSeen(): ?\DateTimeInterface
    {
        return $this->lastSeen;
    }

    /**
     * @param \DateTimeInterface|null $lastSeen
     */
    public function setLastSeen(?\DateTimeInterface $lastSeen): void
    {
        $this->lastSeen = $lastSeen;
    }

    /**
     * @return bool|null
     */
    public function getIsOnline(): ?bool
    {
        return $this->isOnline;
    }

    /**
     * @param bool|null $isOnline
     */
    public function setIsOnline(?bool $isOnline): void
    {
        $this->isOnline = $isOnline;
    }

    /**
     * @return bool|null
     */
    public function getIsMobile(): ?bool
    {
        return $this->isMobile;
    }

    /**
     * @param bool|null $isMobile
     */
    public function setIsMobile(?bool $isMobile): void
    {
        $this->isMobile = $isMobile;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string|null $status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }
}
