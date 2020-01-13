<?php
declare(strict_types=1);

namespace Ticket\Domain\Category;

use Ticket\Domain\User\UserId;
use Ticket\Domain\User\UserRepository;
use Ticket\Domain\User\UserRole;

class CategoryPermissionService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function canUserManageCategory(UserId $userId): bool
    {
        $user = $this->userRepository->getById($userId);
        return $user->role()->equals(UserRole::admin());
    }
}