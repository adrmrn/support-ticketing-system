<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\CreateTicket;

class CreateTicketCommand
{
    private string $title;
    private string $description;
    private string $categoryId;
    private string $authorId;

    public function __construct(string $title, string $description, string $categoryId, string $authorId)
    {
        $this->title = $title;
        $this->description = $description;
        $this->categoryId = $categoryId;
        $this->authorId = $authorId;
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

    public function authorId(): string
    {
        return $this->authorId;
    }
}