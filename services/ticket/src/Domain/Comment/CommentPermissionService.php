<?php
declare(strict_types=1);

namespace Ticket\Domain\Comment;

use Ticket\Domain\Ticket\TicketId;
use Ticket\Domain\Ticket\TicketRepository;
use Ticket\Domain\User\User;
use Ticket\Domain\User\UserRole;

class CommentPermissionService
{
    private TicketRepository $ticketRepository;
    private CommentRepository $commentRepository;

    public function __construct(
        TicketRepository $ticketRepository,
        CommentRepository $commentRepository
    ) {
        $this->ticketRepository = $ticketRepository;
        $this->commentRepository = $commentRepository;
    }

    public function canUserCommentTicket(User $user, TicketId $ticketId): bool
    {
        if ($user->role()->equals(UserRole::admin())) {
            return true;
        }

        $ticket = $this->ticketRepository->getById($ticketId);
        return $ticket->authorId()->equals($user->id());
    }

    public function canUserManageComment(User $user, CommentId $commentId): bool
    {
        $comment = $this->commentRepository->getById($commentId);
        return $comment->authorId()->equals($user->id());
    }
}