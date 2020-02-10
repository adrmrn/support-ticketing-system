<?php
declare(strict_types=1);

namespace Ticket\Tests\Support\MotherObject\Domain\Ticket\Event;

use Ticket\Domain\Ticket\Event\TicketDescribed;
use Ticket\Domain\Ticket\TicketDescription;
use Ticket\Domain\Ticket\TicketId;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketDescriptionMother;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketIdMother;

class TicketDescribedMother
{
    public static function create(TicketId $ticketId, TicketDescription $description): TicketDescribed
    {
        return new TicketDescribed($ticketId, $description);
    }

    public static function createWithParams(array $params = []): TicketDescribed
    {
        $ticketId = $params['id'] ?? TicketIdMother::createDefault();
        $description = $params['description'] ?? TicketDescriptionMother::createDefault();

        return new TicketDescribed($ticketId, $description);
    }

    public static function createDefault(): TicketDescribed
    {
        return self::createWithParams([]);
    }
}