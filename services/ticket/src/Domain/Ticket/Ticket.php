<?php
declare(strict_types=1);

namespace Ticket\Domain\Ticket;

use Ticket\Domain\Category\CategoryId;
use Ticket\Domain\Comment\Comment;
use Ticket\Domain\Comment\CommentContent;
use Ticket\Domain\Comment\CommentId;
use Ticket\Domain\User\UserId;
use Ticket\Shared\Domain\Calendar;

class Ticket
{
    private TicketId $id;
    private TicketTitle $title;
    private TicketDescription $description;
    private CategoryId $category;
    private UserId $authorId;
    private TicketStatus $status;
    private \DateTimeInterface $createdAt;

    public function __construct(
        TicketId $id,
        TicketTitle $title,
        TicketDescription $description,
        CategoryId $category,
        UserId $authorId
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->category = $category;
        $this->authorId = $authorId;

        $this->status = TicketStatus::open();
        $this->createdAt = Calendar::now();
    }

    public function changeTitle(TicketTitle $title): void
    {
        $this->title = $title;
    }

    public function describe(TicketDescription $description): void
    {
        $this->description = $description;
    }

    public function resolve(): void
    {
        $this->status = TicketStatus::resolved();
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function close(): void
    {
        if ($this->status->equals(TicketStatus::resolved())) {
            throw new \InvalidArgumentException('Cannot close resolved ticket.');
        }

        $this->status = TicketStatus::closed();
    }

    public function addComment(CommentId $commentId, CommentContent $content): Comment
    {
        return new Comment(
            $commentId,
            $content,
            $this->id()
        );
    }

    public function id(): TicketId
    {
        return $this->id;
    }

    public function title(): TicketTitle
    {
        return $this->title;
    }

    public function description(): TicketDescription
    {
        return $this->description;
    }

    public function category(): CategoryId
    {
        return $this->category;
    }

    public function authorId(): UserId
    {
        return $this->authorId;
    }

    public function status(): TicketStatus
    {
        return $this->status;
    }

    public function createdAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }
}