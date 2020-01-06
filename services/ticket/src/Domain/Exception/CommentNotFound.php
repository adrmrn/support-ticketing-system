<?php
declare(strict_types=1);

namespace Ticket\Domain\Exception;

use Ticket\Domain\Comment\CommentId;

final class CommentNotFound extends \Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function withCommentId(CommentId $commentId): CommentNotFound
    {
        return new self(
            sprintf('Comment not found. Comment ID: %s', (string)$commentId)
        );
    }
}