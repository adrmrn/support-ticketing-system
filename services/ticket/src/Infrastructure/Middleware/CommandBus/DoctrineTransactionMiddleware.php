<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Middleware\CommandBus;

use Doctrine\ORM\EntityManagerInterface;
use League\Tactician\Middleware;
use Ticket\Infrastructure\Persistence\Doctrine\EventSubscriber\DoctrineDomainEventCollector;

class DoctrineTransactionMiddleware implements Middleware
{
    private EntityManagerInterface $entityManager;
    private DoctrineDomainEventCollector $domainEventCollector;

    public function __construct(EntityManagerInterface $entityManager, DoctrineDomainEventCollector $domainEventCollector)
    {
        $this->entityManager = $entityManager;
        $this->domainEventCollector = $domainEventCollector;
    }

    /**
     * @inheritDoc
     */
    public function execute($command, callable $next)
    {
        try {
            $this->entityManager->beginTransaction();

            $result = $next($command);

            $this->entityManager->flush();
            $this->domainEventCollector->dispatchRaisedEvents();
            $this->entityManager->commit();
        } catch (\Exception $exception) {
            $this->entityManager->rollback();
            throw $exception;
        }

        return $result;
    }
}