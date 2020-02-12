<?php
declare(strict_types=1);

namespace Ticket\Domain\Comment\Event;

use Ticket\Domain\Comment\CommentContent;
use Ticket\Domain\Comment\CommentId;
use Ticket\Domain\Event\DomainEvent;
use Ticket\Domain\Calendar;

class CommentContentEdited implements DomainEvent
{
    private CommentId $commentId;
    private CommentContent $content;
    private \DateTimeInterface $occurredOn;

    public function __construct(CommentId $commentId, CommentContent $content)
    {
        $this->commentId = $commentId;
        $this->content = $content;
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
            'content' => (string)$this->content
        ];
    }

    public function dataAsJson(): string
    {
        return \json_encode($this->data());
    }
}