<?php
declare(strict_types=1);

namespace Ticket\Tests\Support\MotherObject\Domain\Ticket;

use Ticket\Domain\Category\CategoryId;
use Ticket\Domain\Ticket\Ticket;
use Ticket\Domain\Ticket\TicketDescription;
use Ticket\Domain\Ticket\TicketId;
use Ticket\Domain\Ticket\TicketTitle;
use Ticket\Domain\User\UserId;

final class TicketMother
{
    public static function createDefault(): Ticket
    {
        return new Ticket(
            TicketId::fromString('ID-TICKET-1'),
            new TicketTitle('Example title of ticket'),
            new TicketDescription('Example description of ticket'),
            CategoryId::fromString('ID-CATEGORY-1'),
            UserId::fromString('ID-USER-1')
        );
    }

    public static function createResolved(): Ticket
    {
        $ticket = static::createDefault();
        $ticket->resolve();

        return $ticket;
    }
}