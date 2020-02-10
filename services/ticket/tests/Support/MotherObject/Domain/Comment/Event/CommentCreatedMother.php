<?php
declare(strict_types=1);

namespace Ticket\Tests\Support\MotherObject\Domain\Comment\Event;

use Ticket\Domain\Comment\CommentContent;
use Ticket\Domain\Comment\CommentId;
use Ticket\Domain\Comment\Event\CommentCreated;
use Ticket\Domain\Ticket\TicketId;
use Ticket\Domain\User\UserId;
use Ticket\Tests\Support\MotherObject\DateTimeMother;
use Ticket\Tests\Support\MotherObject\Domain\Comment\CommentContentMother;
use Ticket\Tests\Support\MotherObject\Domain\Comment\CommentIdMother;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketIdMother;
use Ticket\Tests\Support\MotherObject\Domain\User\UserIdMother;

class CommentCreatedMother
{
    public static function create(
        CommentId $id,
        CommentContent $content,
        UserId $authorId,
        TicketId $ticketId,
        \DateTimeInterface $createdAt
    ): CommentCreated {
        return new CommentCreated($id, $content, $authorId, $ticketId, $createdAt);
    }

    public static function createWithParams(array $params = []): CommentCreated
    {
        $id = $params['id'] ?? CommentIdMother::createDefault();
        $content = $params['content'] ?? CommentContentMother::createDefault();
        $authorId = $params['author_id'] ?? UserIdMother::createDefault();
        $ticketId = $params['ticket_id'] ?? TicketIdMother::createDefault();
        $createdAt = $params['created_at'] ?? DateTimeMother::createDefault();

        return new CommentCreated($id, $content, $authorId, $ticketId, $createdAt);
    }

    public static function createDefault(): CommentCreated
    {
        return self::createWithParams();
    }
}