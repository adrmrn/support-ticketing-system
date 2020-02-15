<?php
declare(strict_types=1);

namespace Ticket\Application\Query\GetTickets;

use Ticket\Application\Query\Query;
use Ticket\Domain\User\User;

class GetTicketsQuery implements Query
{
    private User $executor;

    public function __construct(User $executor)
    {
        $this->executor = $executor;
    }

    public function executor(): User
    {
        return $this->executor;
    }
}