<?php
declare(strict_types=1);

namespace User\Core\Application\Exception;

use Throwable;

class PasswordCannotBeHashed extends \Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function create(): PasswordCannotBeHashed
    {
        return new self('Password cannot be hashed.');
    }
}
