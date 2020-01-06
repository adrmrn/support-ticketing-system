<?php
declare(strict_types=1);

namespace Ticket\Domain\Comment;

use Ticket\Domain\Exception\CommentNotFound;

interface CommentRepository
{
    public function nextIdentity(): CommentId;
    public function add(Comment $comment): void;

    /**
     * @param CommentId $id
     * @return Comment
     * @throws CommentNotFound
     */
    public function getById(CommentId $id): Comment;
    public function remove(Comment $comment): void;
}