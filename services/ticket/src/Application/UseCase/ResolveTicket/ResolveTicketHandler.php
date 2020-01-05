<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\ResolveTicket;

use Ticket\Domain\Ticket\TicketId;
use Ticket\Domain\Ticket\TicketRepository;

class ResolveTicketHandler
{
    private TicketRepository $ticketRepository;

    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    public function handle(ResolveTicketCommand $command): void
    {
        $ticket = $this->ticketRepository->getById(
            TicketId::fromString($command->ticketId())
        );
        $ticket->resolve();
    }
}