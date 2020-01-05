<?php
declare(strict_types=1);

namespace Ticket\Tests\Support\MotherObject\Domain\Ticket;

use Ticket\Domain\Ticket\TicketTitle;

final class TicketTitleMother
{
    public static function createDefault(): TicketTitle
    {
        return new TicketTitle('Example ticket title');
    }

    public static function create(string $title): TicketTitle
    {
        return new TicketTitle($title);
    }
}