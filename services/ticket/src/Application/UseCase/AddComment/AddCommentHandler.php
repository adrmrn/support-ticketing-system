<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\AddComment;

use Ticket\Domain\Comment\CommentContent;
use Ticket\Domain\Comment\CommentRepository;
use Ticket\Domain\Ticket\TicketId;
use Ticket\Domain\Ticket\TicketRepository;
use Ticket\Domain\User\UserId;

class AddCommentHandler
{
    private CommentRepository $commentRepository;
    private TicketRepository $ticketRepository;

    public function __construct(CommentRepository $commentRepository, TicketRepository $ticketRepository)
    {
        $this->commentRepository = $commentRepository;
        $this->ticketRepository = $ticketRepository;
    }

    public function handle(AddCommentCommand $command): void
    {
        $ticket = $this->ticketRepository->getById(
            TicketId::fromString($command->ticketId())
        );
        $comment = $ticket->addComment(
            $this->commentRepository->nextIdentity(),
            new CommentContent($command->content()),
            UserId::fromString($command->authorId())
        );
        $this->commentRepository->add($comment);
    }
}