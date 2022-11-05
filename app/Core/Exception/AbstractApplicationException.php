<?php

namespace App\Core\Exception;

abstract class AbstractApplicationException extends \Exception
{
    protected array $context = [];

    public function __construct($message = '', array $context = [])
    {
        $this->context = $context;

        parent::__construct($message);
    }

    /**
     * @return array
     */
    public function getContext(): array
    {
        return $this->context;
    }
}
