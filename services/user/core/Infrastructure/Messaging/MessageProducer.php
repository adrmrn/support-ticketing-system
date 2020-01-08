<?php
declare(strict_types=1);

namespace User\Core\Infrastructure\Messaging;

interface MessageProducer
{
    public function open(string $exchangeName): void;

    public function send(
        string $exchangeName,
        string $message,
        string $type,
        int $eventId,
        \DateTimeInterface $eventOccurredOn
    ): void;

    public function close(): void;
}
