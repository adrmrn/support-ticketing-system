<?php
declare(strict_types=1);

namespace User\Core\Infrastructure\Messaging\RabbitMq;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

abstract class RabbitMqMessaging
{
    private AMQPStreamConnection $connection;
    private AMQPChannel $channel;

    public function __construct(AMQPStreamConnection $connection)
    {
        $this->connection = $connection;
        $this->channel = $connection->channel();
    }

    abstract public function open(string $exchangeName): void;

    protected function channel(): AMQPChannel
    {
        return $this->channel;
    }

    public function close(): void
    {
        $this->channel->close();
        $this->connection->close();
    }

    public function __destruct()
    {
        $this->close();
    }
}
