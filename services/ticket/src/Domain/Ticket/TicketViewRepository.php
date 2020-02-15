<?php
declare(strict_types=1);

namespace Ticket\Domain\Ticket;

use Ticket\Domain\Criterion;
use Ticket\Domain\Exception\TicketViewNotFound;

interface TicketViewRepository
{
    /**
     * @param Criterion[] $criteria
     * @return TicketView[]
     */
    public function getAll(Criterion ...$criteria): array;

    /**
     * @param string $ticketId
     * @param Criterion ...$criteria
     * @return TicketView
     * @throws TicketViewNotFound
     */
    public function getById(string $ticketId, Criterion ...$criteria): TicketView;
}