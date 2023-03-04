<?php

namespace App\Services\Telegram\DTO;

class CommandDTO
{
    private string $command;

    private array $arguments = [];

    public function __construct(string $command, array $arguments)
    {
        $this->command = $command;
        $this->arguments = $arguments;
    }

    /**
     * @return string
     */
    public function getCommand(): string
    {
        return $this->command;
    }

    /**
     * @param string $command
     */
    public function setCommand(string $command): void
    {
        $this->command = $command;
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @return string
     */
    public function getArgumentsAsString(): string
    {
        return !empty($this->arguments) ? implode(' ', $this->arguments) : '';
    }

    /**
     * @param array $arguments
     */
    public function setArguments(array $arguments): void
    {
        $this->arguments = $arguments;
    }
}
