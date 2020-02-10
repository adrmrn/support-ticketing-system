<?php
declare(strict_types=1);

namespace Ticket\Domain\Ticket\Event;

use Ticket\Domain\Category\CategoryId;
use Ticket\Domain\Event\DomainEvent;
use Ticket\Domain\Ticket\TicketDescription;
use Ticket\Domain\Ticket\TicketId;
use Ticket\Domain\Ticket\TicketTitle;
use Ticket\Domain\User\UserId;
use Ticket\Shared\Domain\Calendar;

class TicketCreated implements DomainEvent
{
    private TicketId $ticketId;
    private TicketTitle $title;
    private TicketDescription $description;
    private CategoryId $categoryId;
    private UserId $authorId;
    private \DateTimeInterface $createdAt;
    private \DateTimeInterface $occurredOn;

    public function __construct(
        TicketId $ticketId,
        TicketTitle $title,
        TicketDescription $description,
        CategoryId $categoryId,
        UserId $authorId,
        \DateTimeInterface $createdAt
    ) {
        $this->ticketId = $ticketId;
        $this->title = $title;
        $this->description = $description;
        $this->categoryId = $categoryId;
        $this->authorId = $authorId;
        $this->createdAt = $createdAt;
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
            'title' => (string)$this->title,
            'description' => (string)$this->description,
            'categoryId' => (string)$this->categoryId,
            'authorId' => (string)$this->authorId,
            'createdAt' => $this->createdAt->format(Calendar::DEFAULT_DATE_FORMAT)
        ];
    }

    public function dataAsJson(): string
    {
        return \json_encode($this->data());
    }
}