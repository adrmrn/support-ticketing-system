<?php
declare(strict_types=1);

namespace User\Core\Domain\Event;

class StoredEvent
{
    /**
     * There is problem with Doctrine for PHP 7.4
     * So I can't use typed property. Waiting for fix.
     * "Typed property must not be accessed before initialization"
     *
     * @var int
     */
    private $eventId;
    private string $eventName;
    private string $aggregateId;
    private \DateTimeInterface $occurredOn;
    private int $version;
    private string $eventDataAsJson;

    public function __construct(
        string $eventName,
        string $aggregateId,
        \DateTimeInterface $occurredOn,
        int $version,
        string $eventDataAsJson
    ) {
        $this->eventName = $eventName;
        $this->aggregateId = $aggregateId;
        $this->occurredOn = $occurredOn;
        $this->version = $version;
        $this->eventDataAsJson = $eventDataAsJson;
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

    public function eventDataAsJson(): string
    {
        return $this->eventDataAsJson;
    }
}
