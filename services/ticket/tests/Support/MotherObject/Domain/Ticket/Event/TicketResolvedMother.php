<?php
declare(strict_types=1);

namespace Ticket\Tests\Support\MotherObject\Domain\Ticket\Event;

use Ticket\Domain\Ticket\Event\TicketResolved;
use Ticket\Domain\Ticket\TicketId;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketIdMother;

class TicketResolvedMother
{
    public static function create(TicketId $ticketId): TicketResolved
    {
        return new TicketResolved($ticketId);
    }

    public static function createDefault(): TicketResolved
    {
        return self::create(
            TicketIdMother::createDefault()
        );
    }
}