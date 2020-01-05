<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\ResolveTicket;

class ResolveTicketCommand
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