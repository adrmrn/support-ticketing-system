<?php
declare(strict_types=1);

namespace Ticket\Domain\Ticket;

use Ticket\Domain\User\User;
use Ticket\Domain\User\UserRole;

class TicketPermissionService
{
    public function canUserCreateTicket(User $user): bool
    {
        return $user->role()->equals(UserRole::customer());
    }

    public function canUserManageTicket(User $user, Ticket $ticket): bool
    {
        if ($user->role()->equals(UserRole::admin())) {
            return true;
        }

        return $ticket->authorId()->equals($user->id());
    }

    public function canUserResolveTicket(User $user, Ticket $ticket): bool
    {
        return $ticket->authorId()->equals($user->id());
    }
}