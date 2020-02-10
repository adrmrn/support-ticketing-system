<?php
declare(strict_types=1);

namespace Ticket\Tests\Support\MotherObject\Domain\Ticket\Event;

use Ticket\Domain\Category\CategoryId;
use Ticket\Domain\Ticket\Event\TicketCategoryChanged;
use Ticket\Domain\Ticket\TicketId;
use Ticket\Tests\Support\MotherObject\Domain\Category\CategoryIdMother;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketIdMother;

class TicketCategoryChangedMother
{
    public static function create(TicketId $ticketId, CategoryId $categoryId): TicketCategoryChanged
    {
        return new TicketCategoryChanged($ticketId, $categoryId);
    }

    public static function createWithParams(array $params = []): TicketCategoryChanged
    {
        $ticketId = $params['id'] ?? TicketIdMother::createDefault();
        $categoryId = $params['category_id'] ?? CategoryIdMother::createDefault();

        return new TicketCategoryChanged($ticketId, $categoryId);
    }

    public static function createDefault(): TicketCategoryChanged
    {
        return self::createWithParams([]);
    }
}