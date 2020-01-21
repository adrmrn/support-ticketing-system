<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\AddComment;

use Ticket\Application\Exception\PermissionException;
use Ticket\Domain\Comment\CommentContent;
use Ticket\Domain\Comment\CommentPermissionService;
use Ticket\Domain\Comment\CommentRepository;
use Ticket\Domain\Ticket\TicketId;
use Ticket\Domain\Ticket\TicketRepository;
use Ticket\Domain\User\UserId;

class AddCommentHandler
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

    public function handle(AddCommentCommand $command): void
    {
        $ticketId = TicketId::fromString($command->ticketId());
        $user = $command->author();
        if (!$this->commentPermissionService->canUserCommentTicket($user, $ticketId)) {
            throw PermissionException::withMessage('User cannot comment that ticket.');
        }

        $ticket = $this->ticketRepository->getById($ticketId);
        $comment = $ticket->addComment(
            $this->commentRepository->nextIdentity(),
            new CommentContent($command->content()),
            $user->id()
        );
        $this->commentRepository->add($comment);
    }
}