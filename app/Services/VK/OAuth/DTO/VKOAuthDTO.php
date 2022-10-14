<?php

namespace App\Services\VK\OAuth\DTO;

class VKOAuthDTO
{
    private string $accessToken;
    private int $userId;
    private ?string $state = null;
    private ?string $email = null;

    /**
     * @param string $accessToken
     * @param int $userId
     */
    public function __construct(string $accessToken, int $userId)
    {
        $this->accessToken = $accessToken;
        $this->userId = $userId;
    }

    /**
     * @return string|null
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * @param string|null $state
     */
    public function setState(?string $state): void
    {
        $this->state = $state;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }
}
