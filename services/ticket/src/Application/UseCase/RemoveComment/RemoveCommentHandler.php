<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\RemoveComment;

use Ticket\Domain\Comment\CommentContent;
use Ticket\Domain\Comment\CommentId;
use Ticket\Domain\Comment\CommentRepository;
use Ticket\Domain\Exception\LockedTicketCannotBeChanged;
use Ticket\Domain\Ticket\TicketRepository;
use Ticket\Domain\Ticket\TicketStatus;

class RemoveCommentHandler
{
    private CommentRepository $commentRepository;
    private TicketRepository $ticketRepository;

    public function __construct(CommentRepository $commentRepository, TicketRepository $ticketRepository)
    {
        $this->commentRepository = $commentRepository;
        $this->ticketRepository = $ticketRepository;
    }

    public function handle(RemoveCommentCommand $command): void
    {
        $comment = $this->commentRepository->getById(
            CommentId::fromString($command->commentId())
        );
        $ticket = $this->ticketRepository->getById($comment->ticketId());
        if (!$ticket->status()->equals(TicketStatus::open())) {
            throw LockedTicketCannotBeChanged::withTicketId($ticket->id());
        }

        $this->commentRepository->remove($comment);
    }
}