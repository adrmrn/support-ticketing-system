<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\EditComment;

class EditCommentCommand
{
    private string $commentId;
    private string $content;

    public function __construct(string $commentId, string $content)
    {
        $this->commentId = $commentId;
        $this->content = $content;
    }

    public function commentId(): string
    {
        return $this->commentId;
    }

    public function content(): string
    {
        return $this->content;
    }
}