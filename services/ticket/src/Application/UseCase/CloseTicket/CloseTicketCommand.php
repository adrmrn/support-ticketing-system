<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\CloseTicket;

class CloseTicketCommand
{
    private string $ticketId;

    public function __construct(string $ticketId)
    {
        $this->ticketId = $ticketId;
    }

    public function ticketId(): string
    {
        return $this->ticketId;
    }
}