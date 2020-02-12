<?php
declare(strict_types=1);

namespace Ticket\Domain\Comment\Event;

use Ticket\Domain\Comment\CommentContent;
use Ticket\Domain\Comment\CommentId;
use Ticket\Domain\Event\DomainEvent;
use Ticket\Domain\Ticket\TicketId;
use Ticket\Domain\User\UserId;
use Ticket\Domain\Calendar;

class CommentCreated implements DomainEvent
{
    private CommentId $commentId;
    private CommentContent $content;
    private UserId $authorId;
    private TicketId $ticketId;
    private \DateTimeInterface $createdAt;
    private \DateTimeInterface $occurredOn;

    public function __construct(
        CommentId $commentId,
        CommentContent $content,
        UserId $authorId,
        TicketId $ticketId,
        \DateTimeInterface $createdAt
    ) {
        $this->commentId = $commentId;
        $this->content = $content;
        $this->authorId = $authorId;
        $this->ticketId = $ticketId;
        $this->createdAt = $createdAt;
        $this->occurredOn = Calendar::now();
    }

    public function aggregateId(): string
    {
        return (string)$this->commentId;
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
            'id' => (string)$this->commentId,
            'content' => (string)$this->content,
            'authorId' => (string)$this->authorId,
            'ticketId' => (string)$this->ticketId,
            'createdAt' => $this->createdAt->format(Calendar::DEFAULT_DATE_FORMAT)
        ];
    }

    public function dataAsJson(): string
    {
        return \json_encode($this->data());
    }
}