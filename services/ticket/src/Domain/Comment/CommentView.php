<?php
declare(strict_types=1);

namespace Ticket\Domain\Comment;

use Ticket\Domain\View;

class CommentView implements View
{
    private string $id;
    private string $content;
    private string $authorId;
    private string $createdAt;

    public function __construct(string $id, string $content, string $authorId, string $createdAt)
    {
        $this->id = $id;
        $this->content = $content;
        $this->authorId = $authorId;
        $this->createdAt = $createdAt;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'authorId' => $this->authorId,
            'createdAt' => $this->createdAt
        ];
    }
}