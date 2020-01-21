<?php
declare(strict_types=1);

namespace Ticket\Domain\User;

use Ticket\Domain\Exception\UnsupportedUserRole;

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

    /**
     * @param string $role
     * @return UserRole
     * @throws UnsupportedUserRole
     */
    public static function fromString(string $role): UserRole
    {
        switch ($role) {
            case self::ADMIN:
                return new self(self::ADMIN);
                break;

            case self::CUSTOMER:
                return new self(self::CUSTOMER);
                break;
        }

        throw UnsupportedUserRole::withRole($role);
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