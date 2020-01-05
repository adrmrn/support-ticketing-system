<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\AddComment;

class AddCommentCommand
{
    private string $ticketId;
    private string $content;
    private string $authorId;

    public function __construct(string $ticketId, string $content, string $authorId)
    {
        $this->ticketId = $ticketId;
        $this->content = $content;
        $this->authorId = $authorId;
    }

    public function ticketId(): string
    {
        return $this->ticketId;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function authorId(): string
    {
        return $this->authorId;
    }
}