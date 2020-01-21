<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\ResolveTicket;

use Ticket\Domain\User\User;

class ResolveTicketCommand
{
    private string $ticketId;
    private User $executor;

    public function __construct(string $ticketId, User $executor)
    {
        $this->ticketId = $ticketId;
        $this->executor = $executor;
    }

    public function ticketId(): string
    {
        return $this->ticketId;
    }

    public function executor(): User
    {
        return $this->executor;
    }
}