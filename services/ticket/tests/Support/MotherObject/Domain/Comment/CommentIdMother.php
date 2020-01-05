<?php
declare(strict_types=1);

namespace Ticket\Tests\Support\MotherObject\Domain\Comment;

use Ticket\Domain\Comment\CommentId;

class CommentIdMother
{
    public static function create(string $commentId): CommentId
    {
        return CommentId::fromString($commentId);
    }

    public static function createDefault(): CommentId
    {
        return CommentId::fromString('ID-COMMENT-1');
    }
}