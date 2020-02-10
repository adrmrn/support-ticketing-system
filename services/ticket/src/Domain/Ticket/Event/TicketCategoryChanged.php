<?php
declare(strict_types=1);

namespace Ticket\Domain\Ticket\Event;

use Ticket\Domain\Category\CategoryId;
use Ticket\Domain\Event\DomainEvent;
use Ticket\Domain\Ticket\TicketId;
use Ticket\Shared\Domain\Calendar;

class TicketCategoryChanged implements DomainEvent
{
    private TicketId $ticketId;
    private CategoryId $categoryId;
    private \DateTimeInterface $occurredOn;

    public function __construct(TicketId $ticketId, CategoryId $categoryId)
    {
        $this->ticketId = $ticketId;
        $this->categoryId = $categoryId;
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
            'categoryId' => (string)$this->categoryId
        ];
    }

    public function dataAsJson(): string
    {
        return \json_encode($this->data());
    }
}