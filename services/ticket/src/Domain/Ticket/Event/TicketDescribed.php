<?php
declare(strict_types=1);

namespace Ticket\Domain\Ticket\Event;

use Ticket\Domain\Event\DomainEvent;
use Ticket\Domain\Ticket\TicketDescription;
use Ticket\Domain\Ticket\TicketId;
use Ticket\Shared\Domain\Calendar;

class TicketDescribed implements DomainEvent
{
    private TicketId $ticketId;
    private TicketDescription $description;
    private \DateTimeInterface $occurredOn;

    public function __construct(TicketId $ticketId, TicketDescription $description)
    {
        $this->ticketId = $ticketId;
        $this->description = $description;
        $this->occurredOn = Calendar::now();
    }

    public function aggregateId(): string
    {
        return (string)$this->ticketId;
    }

    public function occurredOn(): \DateTimeInterface
    {
        return $this->occurredOn;
    }

    public function version(): int
    {
        return 0;
    }

    public function data(): array
    {
        return [
            'id' => (string)$this->ticketId,
            'description' => (string)$this->description
        ];
    }

    public function dataAsJson(): string
    {
        return \json_encode($this->data());
    }
}