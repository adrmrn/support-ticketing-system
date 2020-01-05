<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\EditComment;

use Ticket\Domain\Comment\CommentContent;
use Ticket\Domain\Comment\CommentId;
use Ticket\Domain\Comment\CommentRepository;
use Ticket\Domain\Exception\LockedTicketCannotBeChanged;
use Ticket\Domain\Ticket\TicketRepository;
use Ticket\Domain\Ticket\TicketStatus;

class EditCommentHandler
{
    private CommentRepository $commentRepository;
    private TicketRepository $ticketRepository;

    public function __construct(CommentRepository $commentRepository, TicketRepository $ticketRepository)
    {
        $this->commentRepository = $commentRepository;
        $this->ticketRepository = $ticketRepository;
    }

    public function handle(EditCommentCommand $command): void
    {
        $comment = $this->commentRepository->getById(
            CommentId::fromString($command->commentId())
        );
        $ticket = $this->ticketRepository->getById($comment->ticketId());
        if (!$ticket->status()->equals(TicketStatus::open())) {
            throw LockedTicketCannotBeChanged::withTicketId($ticket->id());
        }

        $comment->edit(new CommentContent($command->content()));
    }
}