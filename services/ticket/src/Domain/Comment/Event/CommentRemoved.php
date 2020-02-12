<?php
declare(strict_types=1);

namespace Ticket\Domain\Comment\Event;

use Ticket\Domain\Comment\CommentId;
use Ticket\Domain\Event\DomainEvent;
use Ticket\Domain\Calendar;

class CommentRemoved implements DomainEvent
{
    private CommentId $commentId;
    private \DateTimeInterface $occurredOn;

    public function __construct(CommentId $commentId)
    {
        $this->commentId = $commentId;
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
            'id' => (string)$this->commentId
        ];
    }

    public function dataAsJson(): string
    {
        return \json_encode($this->data());
    }
}