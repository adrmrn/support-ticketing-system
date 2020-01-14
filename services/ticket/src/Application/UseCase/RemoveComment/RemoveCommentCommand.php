<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\RemoveComment;

class RemoveCommentCommand
{
    private string $commentId;
    private string $executorId;

    public function __construct(string $commentId, string $executorId)
    {
        $this->commentId = $commentId;
        $this->executorId = $executorId;
    }

    public function commentId(): string
    {
        return $this->commentId;
    }

    public function executorId(): string
    {
        return $this->executorId;
    }
}