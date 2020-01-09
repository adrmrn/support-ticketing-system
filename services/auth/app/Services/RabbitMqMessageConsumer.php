<?php
declare(strict_types=1);

namespace App\Services;

class RabbitMqMessageConsumer extends RabbitMqMessaging implements MessageConsumer
{
    private string $queueName;

    public function open(string $exchangeName): void
    {
        $channel = $this->channel();
        $channel->exchange_declare($exchangeName, 'fanout', false, true, false);
        [$queueName, ,] = $channel->queue_declare('', false, false, true, false);
        $channel->queue_bind($queueName, $exchangeName);
        $this->queueName = $queueName;
    }

    public function consume(string $exchangeName, callable $handler): void
    {
        $this->channel()->basic_consume($this->queueName, '', false, true, false, false, $handler);
        while ($this->channel()->is_consuming()) {
            $this->channel()->wait();
        }
    }
}
