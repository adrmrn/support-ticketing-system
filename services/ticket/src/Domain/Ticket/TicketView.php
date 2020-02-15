<?php
declare(strict_types=1);

namespace Ticket\Domain\Ticket;

use Ticket\Domain\Comment\CommentView;
use Ticket\Domain\View;

class TicketView implements View
{
    private string $id;
    private string $title;
    private string $description;
    private string $categoryId;
    private string $authorId;
    private string $status;
    private string $createdAt;
    private array $comments;

    public function __construct(
        string $id,
        string $title,
        string $description,
        string $categoryId,
        string $authorId,
        string $status,
        string $createdAt,
        array $comments = []
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->categoryId = $categoryId;
        $this->authorId = $authorId;
        $this->status = $status;
        $this->createdAt = $createdAt;
        $this->comments = $comments;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'categoryId' => $this->categoryId,
            'authorId' => $this->authorId,
            'status' => $this->status,
            'createdAt' => $this->createdAt,
            'comments' => array_map(
                fn(CommentView $comment) => $comment->toArray(),
                $this->comments
            )
        ];
    }
}