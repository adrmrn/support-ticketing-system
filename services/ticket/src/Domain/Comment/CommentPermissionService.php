<?php
declare(strict_types=1);

namespace Ticket\Domain\Comment;

use Ticket\Domain\Ticket\Ticket;
use Ticket\Domain\User\User;
use Ticket\Domain\User\UserRole;

class CommentPermissionService
{
    public function canUserCommentTicket(User $user, Ticket $ticket): bool
    {
        if ($user->role()->equals(UserRole::admin())) {
            return true;
        }

        return $ticket->authorId()->equals($user->id());
    }

    public function canUserManageComment(User $user, Comment $comment): bool
    {
        return $comment->authorId()->equals($user->id());
    }
}