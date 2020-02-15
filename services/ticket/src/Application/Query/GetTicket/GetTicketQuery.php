<?php
declare(strict_types=1);

namespace Ticket\Application\Query\GetTicket;

use Ticket\Application\Query\Query;
use Ticket\Domain\User\User;

class GetTicketQuery implements Query
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