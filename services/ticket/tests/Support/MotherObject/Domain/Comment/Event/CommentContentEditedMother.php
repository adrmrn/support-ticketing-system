<?php
declare(strict_types=1);

namespace Ticket\Tests\Support\MotherObject\Domain\Comment\Event;

use Ticket\Domain\Comment\CommentContent;
use Ticket\Domain\Comment\CommentId;
use Ticket\Domain\Comment\Event\CommentContentEdited;
use Ticket\Tests\Support\MotherObject\Domain\Comment\CommentContentMother;
use Ticket\Tests\Support\MotherObject\Domain\Comment\CommentIdMother;

class CommentContentEditedMother
{
    public static function create(CommentId $commentId, CommentContent $content): CommentContentEdited
    {
        return new CommentContentEdited($commentId, $content);
    }

    public static function createWithParams(array $params = []): CommentContentEdited
    {
        $id = $params['id'] ?? CommentIdMother::createDefault();
        $content = $params['content'] ?? CommentContentMother::createDefault();

        return new CommentContentEdited($id, $content);
    }

    public static function createDefault(): CommentContentEdited
    {
        return self::createWithParams();
    }
}