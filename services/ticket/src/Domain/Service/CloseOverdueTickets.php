<?php
declare(strict_types=1);

namespace Ticket\Domain\Service;

use Ticket\Domain\Service\FindOverdueTickets;
use Ticket\Domain\Ticket\TicketRepository;
use Ticket\Domain\Time;

class CloseOverdueTickets
{
    /**
     * OVERDUE_LIMIT is constant that define how long Ticket
     * can be opened without any author's activity.
     * 
     * 60 (seconds) * 60 (minutes) * 24 (hours) * 30 (days) = 1 month
     */
    public const OVERDUE_SECONDS_LIMIT = 60 * 60 * 24 * 30;
    private FindOverdueTickets $findOverdueTickets;
    private TicketRepository $ticketRepository;

    public function __construct(FindOverdueTickets $findOverdueTickets, TicketRepository $ticketRepository)
    {
        $this->findOverdueTickets = $findOverdueTickets;
        $this->ticketRepository = $ticketRepository;
    }

    /**
     * @throws \Ticket\Domain\Exception\InvalidTime
     * @throws \Ticket\Domain\Exception\ResolvedTicketCannotBeClosed
     */
    public function execute(): void
    {
        $overdueLimit = Time::fromSeconds(self::OVERDUE_SECONDS_LIMIT);
        $ticketsIds = $this->findOverdueTickets->execute($overdueLimit);
        $tickets = $this->ticketRepository->getByIds(...$ticketsIds);
        foreach ($tickets as $ticket) {
            $ticket->close();
        }
    }
}