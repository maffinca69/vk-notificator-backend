<?php

namespace App\Services\VK\OAuth\DTO;

class VKOAuthDTO
{
    /**
     * @param string $accessToken
     * @param int $userId
     * @param string|null $state
     * @param string|null $email
     */
    public function __construct(
        private string $accessToken,
        private int $userId,
        private ?string $state = null,
        private ?string $email = null
    ) {
    }

    /**
     * @param string|null $state
     */
    public function setState(?string $state): void
    {
        $this->state = $state;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
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
