<?php
declare(strict_types=1);

namespace App\Exceptions;

use Throwable;

final class UnsupportedAccountType extends \Exception
{
    private function __construct($message)
    {
        parent::__construct($message);
    }

    public static function withAccountType(string $accountType): UnsupportedAccountType
    {
        return new self(
            sprintf('Unsupported account type. Account type: %s', $accountType)
        );
    }
}
