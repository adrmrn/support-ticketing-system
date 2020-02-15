<?php
declare(strict_types=1);

namespace Ticket\Domain\Ticket;

use Ticket\Domain\Criterion;

interface TicketViewRepository
{
    /**
     * @param Criterion[] $criteria
     * @return TicketView[]
     */
    public function getAll(Criterion ...$criteria): array;
}