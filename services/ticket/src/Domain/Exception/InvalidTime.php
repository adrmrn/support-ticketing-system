<?php
declare(strict_types=1);

namespace Ticket\Domain\Exception;

use Ticket\Domain\DomainException;

class InvalidTime extends DomainException
{
    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function withSeconds(int $timeInSeconds): InvalidTime
    {
        return new self(
            sprintf('Provided time is invalid. Time in seconds: %d', $timeInSeconds)
        );
    }
}