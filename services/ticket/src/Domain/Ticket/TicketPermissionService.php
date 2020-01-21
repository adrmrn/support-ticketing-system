<?php
declare(strict_types=1);

namespace Ticket\Domain\Ticket;

use Ticket\Domain\User\User;
use Ticket\Domain\User\UserRole;

class TicketPermissionService
{
    private TicketRepository $ticketRepository;

    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    public function canUserCreateTicket(User $user): bool
    {
        return $user->role()->equals(UserRole::customer());
    }

    public function canUserManageTicket(User $user, TicketId $ticketId): bool
    {
        if ($user->role()->equals(UserRole::admin())) {
            return true;
        }

        $ticket = $this->ticketRepository->getById($ticketId);
        return $ticket->authorId()->equals($user->id());
    }

    public function canUserResolveTicket(User $user, TicketId $ticketId): bool
    {
        $ticket = $this->ticketRepository->getById($ticketId);
        return $ticket->authorId()->equals($user->id());
    }
}