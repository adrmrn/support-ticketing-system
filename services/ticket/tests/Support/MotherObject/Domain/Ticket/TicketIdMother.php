<?php
declare(strict_types=1);

namespace Ticket\Tests\Support\MotherObject\Domain\Ticket;

use Ticket\Domain\Ticket\TicketId;

final class TicketIdMother
{
    public static function create(string $id): TicketId
    {
        return TicketId::fromString($id);
    }

    public static function createDefault(): TicketId
    {
        return TicketId::fromString('ID-TICKET-1');
    }
}