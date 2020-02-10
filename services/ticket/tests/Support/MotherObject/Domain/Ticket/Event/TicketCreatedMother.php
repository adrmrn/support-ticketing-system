<?php
declare(strict_types=1);

namespace Ticket\Tests\Support\MotherObject\Domain\Ticket\Event;

use Ticket\Domain\Category\CategoryId;
use Ticket\Domain\Ticket\Event\TicketCreated;
use Ticket\Domain\Ticket\TicketDescription;
use Ticket\Domain\Ticket\TicketId;
use Ticket\Domain\Ticket\TicketTitle;
use Ticket\Domain\User\UserId;
use Ticket\Tests\Support\MotherObject\Domain\Category\CategoryIdMother;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketDescriptionMother;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketIdMother;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketTitleMother;
use Ticket\Tests\Support\MotherObject\Domain\User\UserIdMother;

class TicketCreatedMother
{
    public static function create(
        TicketId $id,
        TicketTitle $title,
        TicketDescription $description,
        CategoryId $categoryId,
        UserId $authorId
    ): TicketCreated {
        return new TicketCreated($id, $title, $description, $categoryId, $authorId);
    }

    public static function createWithParams(array $params = []): TicketCreated
    {
        $id = $params['id'] ?? TicketIdMother::createDefault();
        $title = $params['title'] ?? TicketTitleMother::createDefault();
        $description = $params['description'] ?? TicketDescriptionMother::createDefault();
        $categoryId = $params['category_id'] ?? CategoryIdMother::createDefault();
        $authorId = $params['author_id'] ?? UserIdMother::createDefault();

        return new TicketCreated($id, $title, $description, $categoryId, $authorId);
    }

    public static function createDefault(): TicketCreated
    {
        return self::createWithParams();
    }
}