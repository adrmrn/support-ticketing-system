<?php
declare(strict_types=1);

namespace Ticket\Domain\Ticket\Event;

use Ticket\Domain\Event\DomainEvent;
use Ticket\Domain\Ticket\TicketId;
use Ticket\Domain\Ticket\TicketTitle;
use Ticket\Shared\Domain\Calendar;

class TicketTitleChanged implements DomainEvent
{
    private TicketId $ticketId;
    private TicketTitle $title;
    private \DateTimeInterface $occurredOn;

    public function __construct(TicketId $ticketId, TicketTitle $title)
    {
        $this->ticketId = $ticketId;
        $this->title = $title;
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
            'title' => (string)$this->title
        ];
    }

    public function dataAsJson(): string
    {
        return \json_encode($this->data());
    }
}