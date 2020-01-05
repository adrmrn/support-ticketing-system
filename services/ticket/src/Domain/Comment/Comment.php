<?php
declare(strict_types=1);

namespace Ticket\Domain\Comment;

use Ticket\Domain\Ticket\TicketId;
use Ticket\Domain\User\UserId;
use Ticket\Shared\Domain\Calendar;

class Comment
{
    private CommentId $id;
    private CommentContent $content;
    private UserId $authorId;
    private TicketId $ticketId;
    private \DateTimeInterface $createdAt;

    public function __construct(CommentId $id, CommentContent $content, UserId $authorId, TicketId $ticketId)
    {
        $this->id = $id;
        $this->content = $content;
        $this->authorId = $authorId;
        $this->ticketId = $ticketId;
        $this->createdAt = Calendar::now();
    }

    public function edit(CommentContent $content): void
    {
        $this->content = $content;
    }

    public function id(): CommentId
    {
        return $this->id;
    }

    public function content(): CommentContent
    {
        return $this->content;
    }

    public function authorId(): UserId
    {
        return $this->authorId;
    }

    public function ticketId(): TicketId
    {
        return $this->ticketId;
    }

    public function createdAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }
}