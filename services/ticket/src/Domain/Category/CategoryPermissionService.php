<?php
declare(strict_types=1);

namespace Ticket\Domain\Category;

use Ticket\Domain\User\User;
use Ticket\Domain\User\UserRole;

class CategoryPermissionService
{
    public function canUserManageCategory(User $user): bool
    {
        return $user->role()->equals(UserRole::admin());
    }
}