<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\CloseTicket;

use Ticket\Domain\Ticket\TicketId;
use Ticket\Domain\Ticket\TicketRepository;

class CloseTicketHandler
{
    private TicketRepository $ticketRepository;

    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    public function handle(CloseTicketCommand $command): void
    {
        $ticket = $this->ticketRepository->getById(
            TicketId::fromString($command->ticketId())
        );
        $ticket->close();
    }
}