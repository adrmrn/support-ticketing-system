<?php
declare(strict_types=1);

namespace Ticket\Domain\Comment;

use Ticket\Domain\Ticket\TicketId;
use Ticket\Domain\Ticket\TicketRepository;
use Ticket\Domain\User\UserId;
use Ticket\Domain\User\UserRepository;
use Ticket\Domain\User\UserRole;

class CommentPermissionService
{
    private UserRepository $userRepository;
    private TicketRepository $ticketRepository;
    private CommentRepository $commentRepository;

    public function __construct(
        UserRepository $userRepository,
        TicketRepository $ticketRepository,
        CommentRepository $commentRepository
    ) {
        $this->userRepository = $userRepository;
        $this->ticketRepository = $ticketRepository;
        $this->commentRepository = $commentRepository;
    }

    public function canUserCommentTicket(UserId $userId, TicketId $ticketId): bool
    {
        $user = $this->userRepository->getById($userId);
        if ($user->role()->equals(UserRole::admin())) {
            return true;
        }

        $ticket = $this->ticketRepository->getById($ticketId);
        return $ticket->authorId()->equals($userId);
    }

    public function canUserManageComment(UserId $userId, CommentId $commentId): bool
    {
        $comment = $this->commentRepository->getById($commentId);
        return $comment->authorId()->equals($userId);
    }
}