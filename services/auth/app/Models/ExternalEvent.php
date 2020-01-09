<?php
declare(strict_types=1);

namespace App\Models;

class ExternalEvent
{
    private int $id;
    private string $type;
    private array $body;

    private function __construct(int $id, string $type, array $body)
    {
        $this->id = $id;
        $this->type = $type;
        $this->body = $body;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function body(): array
    {
        return $this->body;
    }

    public static function fromJson(string $message): ExternalEvent
    {
        $event = \json_decode($message, true);
        return new self(
            (int)$event['eventId'],
            $event['eventType'],
            \json_decode($event['eventBody'], true)
        );
    }
}
