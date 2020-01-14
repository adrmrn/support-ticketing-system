<?php
declare(strict_types=1);

namespace Ticket\Domain\User;

final class UserRole
{
    private const CUSTOMER = 'customer';
    private const ADMIN = 'admin';

    private string $role;

    private function __construct(string $role)
    {
        $this->role = $role;
    }

    public static function customer(): UserRole
    {
        return new self(self::CUSTOMER);
    }

    public static function admin(): UserRole
    {
        return new self(self::ADMIN);
    }

    public function equals(UserRole $role): bool
    {
        return $this->role === $role->role;
    }

    public function __toString(): string
    {
        return $this->role;
    }
}