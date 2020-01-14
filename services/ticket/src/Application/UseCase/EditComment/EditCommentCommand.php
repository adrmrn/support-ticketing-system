<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\EditComment;

class EditCommentCommand
{
    private string $commentId;
    private string $content;
    private string $executorId;

    public function __construct(string $commentId, string $content, string $executorId)
    {
        $this->commentId = $commentId;
        $this->content = $content;
        $this->executorId = $executorId;
    }

    public function commentId(): string
    {
        return $this->commentId;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function executorId(): string
    {
        return $this->executorId;
    }
}