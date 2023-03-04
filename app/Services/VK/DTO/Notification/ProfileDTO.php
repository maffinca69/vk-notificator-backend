<?php

namespace App\Services\VK\DTO\Notification;

class ProfileDTO
{
    public const FEMALE_SEX_TYPE = 1;
    public const MALE_SEX_TYPE = 2;

    private int $id;
    private int $sex;
    private string $screenName;
    private string $photo50;
    private string $photo100;
    private int $online;
    private string $firstName;
    private string $lastName;
    private bool $canAccessClosed;
    private bool $isClosed;
    private ProfileOnlineInfoDTO $onlineInfo;

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
     * @return int
     */
    public function getSex(): int
    {
        return $this->sex;
    }

    /**
     * @param int $sex
     */
    public function setSex(int $sex): void
    {
        $this->sex = $sex;
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
     * @return int
     */
    public function getOnline(): int
    {
        return $this->online;
    }

    /**
     * @param int $online
     */
    public function setOnline(int $online): void
    {
        $this->online = $online;
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
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
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
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return bool
     */
    public function isCanAccessClosed(): bool
    {
        return $this->canAccessClosed;
    }

    /**
     * @param bool $canAccessClosed
     */
    public function setCanAccessClosed(bool $canAccessClosed): void
    {
        $this->canAccessClosed = $canAccessClosed;
    }

    /**
     * @return bool
     */
    public function isClosed(): bool
    {
        return $this->isClosed;
    }

    /**
     * @param bool $isClosed
     */
    public function setIsClosed(bool $isClosed): void
    {
        $this->isClosed = $isClosed;
    }

    /**
     * @return ProfileOnlineInfoDTO
     */
    public function getOnlineInfo(): ProfileOnlineInfoDTO
    {
        return $this->onlineInfo;
    }

    /**
     * @param ProfileOnlineInfoDTO $onlineInfo
     */
    public function setOnlineInfo(ProfileOnlineInfoDTO $onlineInfo): void
    {
        $this->onlineInfo = $onlineInfo;
    }
}
