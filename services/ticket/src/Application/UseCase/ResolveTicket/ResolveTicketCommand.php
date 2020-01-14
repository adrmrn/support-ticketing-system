<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\ResolveTicket;

class ResolveTicketCommand
{
    private string $ticketId;
    private string $executorId;

    public function __construct(string $ticketId, string $executorId)
    {
        $this->ticketId = $ticketId;
        $this->executorId = $executorId;
    }

    public function ticketId(): string
    {
        return $this->ticketId;
    }

    public function executorId(): string
    {
        return $this->executorId;
    }
}