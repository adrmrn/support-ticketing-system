<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\CreateTicket;

use Ticket\Domain\User\User;

class CreateTicketCommand
{
    private string $title;
    private string $description;
    private string $categoryId;
    private User $author;

    public function __construct(string $title, string $description, string $categoryId, User $author)
    {
        $this->title = $title;
        $this->description = $description;
        $this->categoryId = $categoryId;
        $this->author = $author;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function categoryId(): string
    {
        return $this->categoryId;
    }

    public function author(): User
    {
        return $this->author;
    }
}