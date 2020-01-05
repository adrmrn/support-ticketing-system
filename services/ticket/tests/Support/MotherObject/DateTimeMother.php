<?php
declare(strict_types=1);

namespace Ticket\Tests\Support\MotherObject;

final class DateTimeMother
{
    public static function createDefault(): \DateTimeInterface
    {
        return new \DateTimeImmutable('2020-01-01 08:00:00');
    }

    public static function create(string $dateAsString): \DateTimeInterface
    {
        return new \DateTimeImmutable($dateAsString);
    }
}