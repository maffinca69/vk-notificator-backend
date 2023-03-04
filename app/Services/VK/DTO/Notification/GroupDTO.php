<?php

namespace App\Services\VK\DTO\Notification;

class GroupDTO
{
    private int $id;
    private string $name;
    private string $screenName;
    private bool $is_closed;
    private string $type;
    private bool $isAdmin;
    private bool $isMember;
    private bool $isAdvertiser;
    private string $photo50;
    private string $photo100;
    private string $photo200;

    /**
     * @param int $id
     */
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getScreenName(): string
    {
        return $this->screenName;
    }

    /**
     * @param string $screenName
     */
    public function setScreenName(string $screenName): void
    {
        $this->screenName = $screenName;
    }

    /**
     * @return bool
     */
    public function isIsClosed(): bool
    {
        return $this->is_closed;
    }

    /**
     * @param bool $is_closed
     */
    public function setIsClosed(bool $is_closed): void
    {
        $this->is_closed = $is_closed;
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
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    /**
     * @param bool $isAdmin
     */
    public function setIsAdmin(bool $isAdmin): void
    {
        $this->isAdmin = $isAdmin;
    }

    /**
     * @return bool
     */
    public function isMember(): bool
    {
        return $this->isMember;
    }

    /**
     * @param bool $isMember
     */
    public function setIsMember(bool $isMember): void
    {
        $this->isMember = $isMember;
    }

    /**
     * @return bool
     */
    public function isAdvertiser(): bool
    {
        return $this->isAdvertiser;
    }

    /**
     * @param bool $isAdvertiser
     */
    public function setIsAdvertiser(bool $isAdvertiser): void
    {
        $this->isAdvertiser = $isAdvertiser;
    }

    /**
     * @return string
     */
    public function getPhoto50(): string
    {
        return $this->photo50;
    }

    /**
     * @param string $photo50
     */
    public function setPhoto50(string $photo50): void
    {
        $this->photo50 = $photo50;
    }

    /**
     * @return string
     */
    public function getPhoto100(): string
    {
        return $this->photo100;
    }

    /**
     * @param string $photo100
     */
    public function setPhoto100(string $photo100): void
    {
        $this->photo100 = $photo100;
    }

    /**
     * @return string
     */
    public function getPhoto200(): string
    {
        return $this->photo200;
    }

    /**
     * @param string $photo200
     */
    public function setPhoto200(string $photo200): void
    {
        $this->photo200 = $photo200;
    }
}
