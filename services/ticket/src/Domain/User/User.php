<?php
declare(strict_types=1);

namespace Ticket\Domain\User;

interface User
{
    public function id(): UserId;

    public function role(): UserRole;
}