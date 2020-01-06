<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Domain\Ticket;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Ramsey\Uuid\Uuid;
use Ticket\Domain\Exception\TicketNotFound;
use Ticket\Domain\Ticket\Ticket;
use Ticket\Domain\Ticket\TicketId;
use Ticket\Domain\Ticket\TicketRepository;

class DoctrineTicketRepository implements TicketRepository
{
    private EntityManagerInterface $entityManager;
    private ObjectRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Ticket::class);
    }

    public function nextIdentity(): TicketId
    {
        return TicketId::fromString(Uuid::uuid4()->toString());
    }

    public function add(Ticket $ticket): void
    {
        $this->entityManager->persist($ticket);
    }

    /**
     * @inheritDoc
     */
    public function getById(TicketId $id): Ticket
    {
        $ticket = $this->repository->find($id);
        if (!($ticket instanceof Ticket)) {
            throw TicketNotFound::withTicketId($id);
        }

        return $ticket;
    }
}