<?php

namespace App\Services\Telegram\DTO;

class FromDTO
{
    private float $id;

    private bool $isBot;

    private string $firstName;

    private string $lastName;

    private ?string $username;

    private string $languageCode;

    private string $fullName;

    public function __construct(float $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return trim(implode(' ', [$this->getFirstName(), $this->getLastName()]));
    }

    /**
     * @param string $fullName
     */
    public function setFullName(string $fullName): void
    {
        $this->fullName = $fullName;
    }

    /**
     * @return float
     */
    public function getId(): float
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isBot(): bool
    {
        return $this->isBot;
    }

    /**
     * @param bool $isBot
     * @return FromDTO
     */
    public function setIsBot(bool $isBot): FromDTO
    {
        $this->isBot = $isBot;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return FromDTO
     */
    public function setFirstName(string $firstName): FromDTO
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return FromDTO
     */
    public function setLastName(string $lastName): FromDTO
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     * @return FromDTO
     */
    public function setUsername(?string $username): FromDTO
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getLanguageCode(): string
    {
        return $this->languageCode;
    }

    /**
     * @param string $languageCode
     * @return FromDTO
     */
    public function setLanguageCode(string $languageCode): FromDTO
    {
        $this->languageCode = $languageCode;

        return $this;
    }
}
