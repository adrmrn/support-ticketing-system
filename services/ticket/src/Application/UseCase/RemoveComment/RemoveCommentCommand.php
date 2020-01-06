<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\RemoveComment;

class RemoveCommentCommand
{
    private string $commentId;
    private string $authorId;

    public function __construct(string $commentId, string $authorId)
    {
        $this->commentId = $commentId;
        $this->authorId = $authorId;
    }

    public function commentId(): string
    {
        return $this->commentId;
    }

    public function authorId(): string
    {
        return $this->authorId;
    }
}