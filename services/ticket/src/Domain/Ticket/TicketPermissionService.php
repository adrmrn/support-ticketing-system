<?php
declare(strict_types=1);

namespace Ticket\Domain\Ticket;

use Ticket\Domain\User\UserId;
use Ticket\Domain\User\UserRepository;
use Ticket\Domain\User\UserRole;

class TicketPermissionService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function canUserCreateTicket(UserId $userId): bool
    {
        $user = $this->userRepository->getById($userId);
        return $user->role()->equals(UserRole::customer());
    }

    public function canUserManageTicket(UserId $userId): bool
    {
        $user = $this->userRepository->getById($userId);
        return $user->role()->equals(UserRole::admin());
    }
}