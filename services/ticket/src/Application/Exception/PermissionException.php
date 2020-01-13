<?php
declare(strict_types=1);

namespace Ticket\Application\Exception;

use Throwable;

class PermissionException extends \Exception
{
    private function __construct($message)
    {
        parent::__construct($message);
    }

    public static function withMessage(string $message = 'Action is not permitted.'): PermissionException
    {
        return new self($message);
    }
}