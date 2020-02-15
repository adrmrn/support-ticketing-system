<?php
declare(strict_types=1);

namespace Ticket\Application\Query\GetTicket;

use Ticket\Application\Query\Handler;
use Ticket\Domain\Criterion;
use Ticket\Domain\Ticket\TicketView;
use Ticket\Domain\Ticket\TicketViewRepository;
use Ticket\Domain\User\UserRole;

class GetTicketHandler implements Handler
{
    private TicketViewRepository $ticketViewRepository;

    public function __construct(TicketViewRepository $ticketViewRepository)
    {
        $this->ticketViewRepository = $ticketViewRepository;
    }

    public function handle(GetTicketQuery $query): TicketView
    {
        $criteria = [];
        if ($query->executor()->role()->equals(UserRole::customer())) {
            $criteria[] = new Criterion('author_id', (string)$query->executor()->id());
        }

        return $this->ticketViewRepository->getById($query->ticketId(), ...$criteria);
    }
}