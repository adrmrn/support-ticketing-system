<?php
declare(strict_types=1);

namespace Ticket\Tests\Support\MotherObject\Domain\Comment;

use Ticket\Domain\Comment\Comment;
use Ticket\Domain\Comment\CommentContent;
use Ticket\Domain\Comment\CommentId;
use Ticket\Domain\Ticket\TicketId;
use Ticket\Domain\User\UserId;
use Ticket\Tests\Support\MotherObject\Domain\Ticket\TicketIdMother;
use Ticket\Tests\Support\MotherObject\Domain\User\UserIdMother;

class CommentMother
{
    public static function create(
        CommentId $commentId,
        CommentContent $content,
        UserId $authorId,
        TicketId $ticketId
    ): Comment {
        return new Comment(
            $commentId,
            $content,
            $authorId,
            $ticketId
        );
    }

    public static function createWithParams(array $params = []): Comment
    {
        $commentId = $params['id'] ?? CommentIdMother::createDefault();
        $content = $params['content'] ?? CommentContentMother::createDefault();
        $authorId = $params['author_id'] ?? UserIdMother::createDefault();
        $ticketId = $params['ticket_id'] ?? TicketIdMother::createDefault();

        return new Comment(
            $commentId,
            $content,
            $authorId,
            $ticketId
        );
    }
}