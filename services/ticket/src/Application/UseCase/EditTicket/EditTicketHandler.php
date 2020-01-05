<?php
declare(strict_types=1);

namespace Ticket\Application\UseCase\EditTicket;

use Ticket\Domain\Category\CategoryId;
use Ticket\Domain\Category\CategoryRepository;
use Ticket\Domain\Ticket\TicketDescription;
use Ticket\Domain\Ticket\TicketId;
use Ticket\Domain\Ticket\TicketRepository;
use Ticket\Domain\Ticket\TicketTitle;

class EditTicketHandler
{
    private TicketRepository $ticketRepository;
    private CategoryRepository $categoryRepository;

    public function __construct(TicketRepository $ticketRepository, CategoryRepository $categoryRepository)
    {
        $this->ticketRepository = $ticketRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function handle(EditTicketCommand $command): void
    {
        $ticket = $this->ticketRepository->getById(
            TicketId::fromString($command->ticketId())
        );
        $category = $this->categoryRepository->getById(
            CategoryId::fromString($command->categoryId())
        );
        $ticket->changeTitle(new TicketTitle($command->title()));
        $ticket->describe(new TicketDescription($command->description()));
        $ticket->changeCategory($category->id());
    }
}