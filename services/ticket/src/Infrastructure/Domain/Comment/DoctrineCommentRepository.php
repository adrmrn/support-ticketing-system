<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Domain\Comment;

use Ticket\Domain\Comment\Comment;
use Ticket\Domain\Comment\CommentId;
use Ticket\Domain\Comment\CommentRepository;
use Ticket\Domain\Exception\CommentNotFound;

class DoctrineCommentRepository implements CommentRepository
{

    public function nextIdentity(): CommentId
    {
        // TODO: Implement nextIdentity() method.
    }

    public function add(Comment $comment): void
    {
        // TODO: Implement add() method.
    }

    /**
     * @inheritDoc
     */
    public function getById(CommentId $id): Comment
    {
        // TODO: Implement getById() method.
    }
}