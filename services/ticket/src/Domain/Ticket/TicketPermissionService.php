<?php
declare(strict_types=1);

namespace Ticket\Domain\Ticket;

use Ticket\Domain\User\UserId;
use Ticket\Domain\User\UserRepository;
use Ticket\Domain\User\UserRole;

class TicketPermissionService
{
    private UserRepository $userRepository;
    private TicketRepository $ticketRepository;

    public function __construct(UserRepository $userRepository, TicketRepository $ticketRepository)
    {
        $this->userRepository = $userRepository;
        $this->ticketRepository = $ticketRepository;
    }

    public function canUserCreateTicket(UserId $userId): bool
    {
        $user = $this->userRepository->getById($userId);
        return $user->role()->equals(UserRole::customer());
    }

    public function canUserManageTicket(UserId $userId, TicketId $ticketId): bool
    {
        $user = $this->userRepository->getById($userId);
        if ($user->role()->equals(UserRole::admin())) {
            return true;
        }

        $ticket = $this->ticketRepository->getById($ticketId);
        return $ticket->authorId()->equals($userId);
    }

    public function canUserResolveTicket(UserId $userId, TicketId $ticketId): bool
    {
        $ticket = $this->ticketRepository->getById($ticketId);
        return $ticket->authorId()->equals($userId);
    }
}