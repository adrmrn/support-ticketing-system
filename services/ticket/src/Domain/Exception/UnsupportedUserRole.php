<?php
declare(strict_types=1);

namespace Ticket\Domain\Exception;

class UnsupportedUserRole extends \Exception
{
    private function __construct($message)
    {
        parent::__construct($message);
    }

    public static function withRole(string $role): UnsupportedUserRole
    {
        return new self(
            sprintf('Unsupported user role. Role: %s', $role)
        );
    }
}