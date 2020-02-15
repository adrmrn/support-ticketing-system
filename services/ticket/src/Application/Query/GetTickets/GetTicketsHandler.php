<?php
declare(strict_types=1);

namespace Ticket\Application\Query\GetTickets;

use Ticket\Application\Query\Handler;
use Ticket\Domain\Criterion;
use Ticket\Domain\Ticket\TicketView;
use Ticket\Domain\Ticket\TicketViewRepository;
use Ticket\Domain\User\UserRole;

class GetTicketsHandler implements Handler
{
    private TicketViewRepository $ticketViewRepository;

    public function __construct(TicketViewRepository $ticketViewRepository)
    {
        $this->ticketViewRepository = $ticketViewRepository;
    }

    /**
     * @param GetTicketsQuery $query
     * @return TicketView[]
     */
    public function handle(GetTicketsQuery $query): array
    {
        $criteria = [];
        if ($query->executor()->role()->equals(UserRole::customer())) {
            $criteria[] = new Criterion('author_id', (string)$query->executor()->id());
        }

        return $this->ticketViewRepository->getAll(...$criteria);
    }
}