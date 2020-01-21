<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\RemoveComment;

use Ticket\Domain\User\User;

class RemoveCommentCommand
{
    private string $commentId;
    private User $executor;

    public function __construct(string $commentId, User $executor)
    {
        $this->commentId = $commentId;
        $this->executor = $executor;
    }

    public function commentId(): string
    {
        return $this->commentId;
    }

    public function executor(): User
    {
        return $this->executor;
    }
}