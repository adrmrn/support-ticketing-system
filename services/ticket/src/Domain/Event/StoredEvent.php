<?php
declare(strict_types=1);

namespace Ticket\Domain\Event;

class StoredEvent
{
    protected int $eventId;
    private string $eventName;
    private string $aggregateId;
    private \DateTimeInterface $occurredOn;
    private int $version;
    private string $dataAsJson;

    public function __construct(
        string $eventName,
        string $aggregateId,
        \DateTimeInterface $occurredOn,
        int $version,
        string $dataAsJson
    ) {
        $this->eventName = $eventName;
        $this->aggregateId = $aggregateId;
        $this->occurredOn = $occurredOn;
        $this->version = $version;
        $this->dataAsJson = $dataAsJson;
    }

    public function eventId(): int
    {
        return $this->eventId;
    }

    public function eventName(): string
    {
        return $this->eventName;
    }

    public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    public function occurredOn(): \DateTimeInterface
    {
        return $this->occurredOn;
    }

    public function version(): int
    {
        return $this->version;
    }

    public function dataAsJson(): string
    {
        return $this->dataAsJson;
    }
}