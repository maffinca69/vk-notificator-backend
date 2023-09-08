<?php

namespace App\Services\EventBus\PortAdapter\RabbitMQ;

use App\Services\EventBus\EventBusInterface;
use App\Services\EventBus\HandlerInterface;
use Illuminate\Support\Facades\Log;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exception\AMQPRuntimeException;
use PhpAmqpLib\Exception\AMQPTimeoutException;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQService implements EventBusInterface
{
    private const
        MESSAGE_WAITING_TIME_OUT_SECONDS = 3,
        DEFAULT_COMPRESSION_LEVEL = 1,
        CONTENT_TYPE_GZCOMPRESSED = 'text/gzcompressed';

    public function __construct(
        private readonly AMQPStreamConnection $connection,
        private ?HandlerInterface $handler = null,
    ) {
    }

    /**
     * @param string $message
     * @return void
     * @throws \Exception
     */
    public function publish(string $message): void
    {
        $published = false;
        while (!$published) {
            try {
                $published = $this->publishInternal($message);
            } catch (AMQPRuntimeException | \RuntimeException | \ErrorException $e) {
                $this->connection->close();
            }
        }
    }

    /**
     * @param string $message
     * @return bool
     * @throws \Exception
     */
    protected function publishInternal(string $message): bool
    {
        $channel = $this->connection->channel($this->connection->getChannelId());

        $channel->basic_publish(gzcompress($message, self::DEFAULT_COMPRESSION_LEVEL));
        return true;
    }

    public function subscribe(HandlerInterface $handler): void
    {
        $this->handler = $handler;

        try {
            $this->subscribeInternal();
        } catch (AMQPTimeoutException $e) {
            //reconnect не проверяем т.к. отсутствие сообщений не обязательно связанно с разрывом соединения.
            //если же соединение не получится восстановить, то выбросится ErrorException
            $this->connection->close();
        } catch (\RuntimeException | \ErrorException $e) {
            $this->connection->close();
        }
    }

    protected function subscribeInternal(): void
    {
        $channel = $this->connection->channel();

        $channel->queue_declare('logger', false, true, false, false);

        $channel->queue_bind('logger', 'logger');

        // эта настройка равномерно распределяет нагрузку на воркеры, отправляет по 1 сообщению на каждый воркер
        $channel->basic_qos(0, 1, false);

        // подключает $handler к каналу
        $channel->basic_consume(
            queue: 'logger',
            callback: [$this, 'handleCallback']
        );

        while (\count($channel->callbacks)) {
            $channel->wait(timeout: self::MESSAGE_WAITING_TIME_OUT_SECONDS);
        }

        $channel->close();
        $this->connection->close();
    }

    /**
     * @param AMQPMessage $message
     * @return void
     */
    public function handleCallback(AMQPMessage $message): void
    {
        try {
            $this->handler->handle($this->getBody($message));
            $message->ack();
        } catch (\Exception $e) {
            Log::critical($e->getMessage(), $e->getTrace());
        }
    }

    /**
     * @param AMQPMessage $message
     * @return string
     */
    protected function getBody(AMQPMessage $message): string
    {
        $out = $message->has('content_type') && self::CONTENT_TYPE_GZCOMPRESSED === $message->get('content_type') ?
            gzuncompress($message->body) ?? '' :
            $message->body;
        return (string)$out;
    }
}
