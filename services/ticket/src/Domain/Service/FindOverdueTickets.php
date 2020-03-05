<?php
declare(strict_types=1);

namespace Ticket\Domain\Service;

use Ticket\Domain\Ticket\TicketId;
use Ticket\Domain\Time;

interface FindOverdueTickets
{
    /**
     * @param Time $overdueLimit
     * @return TicketId[]
     */
    public function execute(Time $overdueLimit): array;
}