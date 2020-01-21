<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\EditComment;

use Ticket\Domain\User\User;

class EditCommentCommand
{
    private string $commentId;
    private string $content;
    private User $executor;

    public function __construct(string $commentId, string $content, User $executor)
    {
        $this->commentId = $commentId;
        $this->content = $content;
        $this->executor = $executor;
    }

    public function commentId(): string
    {
        return $this->commentId;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function executor(): User
    {
        return $this->executor;
    }
}