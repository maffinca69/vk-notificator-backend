<?php

namespace App\Services\Telegram\DTO;

class ChatDTO
{
    private int $id;

    private string $firstName;

    private string $lastName;

    private string $username;

    private string $type;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
     * @return ChatDTO
     */
    public function setFirstName(string $firstName): ChatDTO
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
     * @return ChatDTO
     */
    public function setLastName(string $lastName): ChatDTO
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return ChatDTO
     */
    public function setUsername(string $username): ChatDTO
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return ChatDTO
     */
    public function setType(string $type): ChatDTO
    {
        $this->type = $type;

        return $this;
    }
}
