<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\AddComment;

use Ticket\Domain\User\User;

class AddCommentCommand
{
    private string $ticketId;
    private string $content;
    private User $author;

    public function __construct(string $ticketId, string $content, User $author)
    {
        $this->ticketId = $ticketId;
        $this->content = $content;
        $this->author = $author;
    }

    public function ticketId(): string
    {
        return $this->ticketId;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function author(): User
    {
        return $this->author;
    }
}