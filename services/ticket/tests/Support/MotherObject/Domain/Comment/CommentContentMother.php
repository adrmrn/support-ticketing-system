<?php
declare(strict_types=1);

namespace Ticket\Tests\Support\MotherObject\Domain\Comment;

use Ticket\Domain\Comment\CommentContent;

class CommentContentMother
{
    public static function create(string $content): CommentContent
    {
        return new CommentContent($content);
    }

    public static function createDefault(): CommentContent
    {
        return new CommentContent('Example of comment content');
    }
}