<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\AddComment;

use Ticket\Application\Exception\PermissionException;
use Ticket\Domain\Comment\CommentContent;
use Ticket\Domain\Comment\CommentPermissionService;
use Ticket\Domain\Comment\CommentRepository;
use Ticket\Domain\Ticket\TicketId;
use Ticket\Domain\Ticket\TicketRepository;

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
        $ticket = $this->ticketRepository->getById(
            TicketId::fromString($command->ticketId())
        );
        $user = $command->author();
        if (!$this->commentPermissionService->canUserCommentTicket($user, $ticket)) {
            throw PermissionException::withMessage('User cannot comment that ticket.');
        }

        $comment = $ticket->addComment(
            $this->commentRepository->nextIdentity(),
            new CommentContent($command->content()),
            $user->id()
        );
        $this->commentRepository->add($comment);
    }
}