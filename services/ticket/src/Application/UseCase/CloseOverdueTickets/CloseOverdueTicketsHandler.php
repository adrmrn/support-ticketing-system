<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\CloseOverdueTickets;

use Ticket\Domain\Service\CloseOverdueTickets;

class CloseOverdueTicketsHandler
{
    private CloseOverdueTickets $closeOverdueTickets;

    public function __construct(CloseOverdueTickets $closeOverdueTickets)
    {
        $this->closeOverdueTickets = $closeOverdueTickets;
    }

    public function handle(CloseOverdueTicketsCommand $command): void
    {
        $this->closeOverdueTickets->execute();
    }
}