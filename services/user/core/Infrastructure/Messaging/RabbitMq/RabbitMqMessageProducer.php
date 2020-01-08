<?php
declare(strict_types=1);

namespace User\Core\Infrastructure\Messaging\RabbitMq;

use PhpAmqpLib\Message\AMQPMessage;
use User\Core\Infrastructure\Messaging\MessageProducer;

class RabbitMqMessageProducer extends RabbitMqMessaging implements MessageProducer
{
    public function open(string $exchangeName): void
    {
        $channel = $this->channel();
        $channel->exchange_declare($exchangeName, 'fanout', false, true, false);
    }

    public function send(
        string $exchangeName,
        string $message,
        string $type,
        int $eventId,
        \DateTimeInterface $eventOccurredOn
    ): void {
        $channel = $this->channel();
        $channel->basic_publish(
            new AMQPMessage(
                \json_encode([
                    'eventId' => $eventId,
                    'eventType' => $type,
                    'eventBody' => $message
                ])
            ),
            $exchangeName
        );
    }
}
