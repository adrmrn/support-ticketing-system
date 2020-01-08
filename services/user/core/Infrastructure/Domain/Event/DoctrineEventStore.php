<?php
declare(strict_types=1);

namespace User\Core\Infrastructure\Domain\Event;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use User\Core\Domain\Event\DomainEvent;
use User\Core\Domain\Event\EventStore;
use User\Core\Domain\Event\StoredEvent;

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
            $event->version(),
            $event->dataAsJson()
        );
        $this->entityManager->persist($storedEvent);
    }

    /**
     * @inheritDoc
     */
    public function allStoredEventsSince(int $eventId): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('e')
            ->from(StoredEvent::class, 'e')
            ->where('e.eventId > :eventId')
            ->orderBy('e.eventId', 'ASC')
            ->setParameter(':eventId', $eventId);
        return $queryBuilder->getQuery()->getResult();
    }
}
