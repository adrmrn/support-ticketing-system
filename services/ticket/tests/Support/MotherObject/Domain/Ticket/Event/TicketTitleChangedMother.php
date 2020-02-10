<?php
declare(strict_types=1);

namespace Ticket\Tests\Support\MotherObject\Domain\Ticket\Event;

use Ticket\Domain\Ticket\Event\TicketTitleChanged;
use Ticket\Domain\Ticket\TicketId;
use Ticket\Domain\Ticket\TicketTitle;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketIdMother;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketTitleMother;

class TicketTitleChangedMother
{
    public static function create(TicketId $ticketId, TicketTitle $title): TicketTitleChanged
    {
        return new TicketTitleChanged($ticketId, $title);
    }

    public static function createWithParams(array $params = []): TicketTitleChanged
    {
        $ticketId = $params['id'] ?? TicketIdMother::createDefault();
        $title = $params['title'] ?? TicketTitleMother::createDefault();

        return new TicketTitleChanged($ticketId, $title);
    }

    public static function createDefault(): TicketTitleChanged
    {
        return self::createWithParams([]);
    }
}