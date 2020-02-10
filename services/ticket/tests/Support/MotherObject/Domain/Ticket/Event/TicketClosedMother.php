<?php
declare(strict_types=1);

namespace Ticket\Tests\Support\MotherObject\Domain\Ticket\Event;

use Ticket\Domain\Ticket\Event\TicketClosed;
use Ticket\Domain\Ticket\TicketId;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketIdMother;

class TicketClosedMother
{
    public static function create(TicketId $ticketId): TicketClosed
    {
        return new TicketClosed($ticketId);
    }

    public static function createDefault(): TicketClosed
    {
        return self::create(
            TicketIdMother::createDefault()
        );
    }
}