<?php
declare(strict_types=1);

namespace User\Core\Infrastructure\Domain\Event;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use User\Core\Shared\Domain\DomainEvent;
use User\Core\Shared\Domain\Event\EventStore;
use User\Core\Shared\Domain\Event\StoredEvent;

class DoctrineEventStore implements EventStore
{
    private EntityManagerInterface $entityManager;
    private ObjectRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(StoredEvent::class);
    }

    public function append(DomainEvent $event)
    {
        $storedEvent = new StoredEvent(
            get_class($event),
            $event->aggregateId(),
            $event->occurredOn(),
            $event->dataAsJson()
        );
        $this->entityManager->persist($storedEvent);
        $this->entityManager->flush();
    }
}
