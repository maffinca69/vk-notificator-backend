<?php

namespace App\Services\Exception;

use App\Exceptions\Handlers\ApiExceptionHandler;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class ExceptionHandlersFactory
{
    public function __construct(private ContainerInterface $container)
    {
    }

    /**
     * @param \Throwable $exception
     * @return ExceptionHandlerInterface|null
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function create(\Throwable $exception): ?ExceptionHandlerInterface
    {
        return match (true) {
            $exception instanceof AbstractAPIException => $this->container->get(ApiExceptionHandler::class),
            $exception instanceof AbstractApplicationException => response('ok'),
            default => null
        };
    }
}
