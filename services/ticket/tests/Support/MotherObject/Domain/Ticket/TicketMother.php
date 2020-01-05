<?php
declare(strict_types=1);

namespace Ticket\Tests\Support\MotherObject\Domain\Ticket;

use Ticket\Domain\Category\CategoryId;
use Ticket\Domain\Ticket\Ticket;
use Ticket\Domain\Ticket\TicketDescription;
use Ticket\Domain\Ticket\TicketId;
use Ticket\Domain\Ticket\TicketTitle;
use Ticket\Domain\User\UserId;
use Ticket\Tests\Support\MotherObject\Domain\Category\CategoryIdMother;
use Ticket\Tests\Support\MotherObject\Domain\User\UserIdMother;

final class TicketMother
{
    public static function create(
        TicketId $id,
        TicketTitle $title,
        TicketDescription $description,
        CategoryId $categoryId,
        UserId $authorId
    ): Ticket {
        return new Ticket(
            $id,
            $title,
            $description,
            $categoryId,
            $authorId
        );
    }

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

    public static function createWithParams(array $params = []): Ticket
    {
        $id = $params['id'] ?? TicketIdMother::createDefault();
        $title = $params['title'] ?? TicketTitleMother::createDefault();
        $description = $params['description'] ?? TicketDescriptionMother::createDefault();
        $categoryId = $params['category_id'] ?? CategoryIdMother::createDefault();
        $authorId = $params['author_id'] ?? UserIdMother::createDefault();

        return new Ticket(
            $id,
            $title,
            $description,
            $categoryId,
            $authorId
        );
    }

    public static function createResolved(): Ticket
    {
        $ticket = static::createDefault();
        $ticket->resolve();

        return $ticket;
    }

    public static function createClosed(): Ticket
    {
        $ticket = static::createDefault();
        $ticket->close();

        return $ticket;
    }
}