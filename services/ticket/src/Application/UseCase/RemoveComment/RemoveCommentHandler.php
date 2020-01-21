<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\RemoveComment;

use Ticket\Application\Exception\PermissionException;
use Ticket\Domain\Comment\CommentContent;
use Ticket\Domain\Comment\CommentId;
use Ticket\Domain\Comment\CommentPermissionService;
use Ticket\Domain\Comment\CommentRepository;
use Ticket\Domain\Exception\LockedTicketCannotBeChanged;
use Ticket\Domain\Ticket\TicketRepository;
use Ticket\Domain\Ticket\TicketStatus;
use Ticket\Domain\User\UserId;

class RemoveCommentHandler
{
    private CommentRepository $commentRepository;
    private TicketRepository $ticketRepository;
    private CommentPermissionService $commentPermissionService;

    public function __construct(
        CommentRepository $commentRepository,
        TicketRepository $ticketRepository,
        CommentPermissionService $commentPermissionService
    ) {
        $this->commentRepository = $commentRepository;
        $this->ticketRepository = $ticketRepository;
        $this->commentPermissionService = $commentPermissionService;
    }

    public function handle(RemoveCommentCommand $command): void
    {
        $user = $command->executor();
        $comment = $this->commentRepository->getById(
            CommentId::fromString($command->commentId())
        );
        if (!$this->commentPermissionService->canUserManageComment($user, $comment)) {
            throw PermissionException::withMessage('User cannot manage that comment.');
        }

        $ticket = $this->ticketRepository->getById($comment->ticketId());
        if (!$ticket->status()->equals(TicketStatus::open())) {
            throw LockedTicketCannotBeChanged::withTicketId($ticket->id());
        }

        $this->commentRepository->remove($comment);
    }
}