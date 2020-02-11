<?php
declare(strict_types=1);

namespace Ticket\Tests\Support\MotherObject\Domain\Comment\Event;

use Ticket\Domain\Comment\CommentId;
use Ticket\Domain\Comment\Event\CommentRemoved;
use Ticket\Tests\Support\MotherObject\Domain\Comment\CommentIdMother;

class CommentRemovedMother
{
    public static function create(CommentId $commentId): CommentRemoved
    {
        return new CommentRemoved($commentId);
    }

    public static function createDefault(): CommentRemoved
    {
        return new CommentRemoved(
            CommentIdMother::createDefault()
        );
    }
}