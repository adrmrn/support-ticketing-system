<?php
declare(strict_types=1);

namespace Ticket\Domain;

use Ticket\Domain\Exception\InvalidTime;

class Time
{
    private int $seconds;

    private function __construct(int $seconds)
    {
        if ($seconds < 0) {
            throw InvalidTime::withSeconds($seconds);
        }

        $this->seconds = $seconds;
    }

    public function seconds(): int
    {
        return $this->seconds;
    }

    /**
     * @param int $seconds
     * @return Time
     * @throws InvalidTime
     */
    public static function fromSeconds(int $seconds): Time
    {
        return new self($seconds);
    }
}