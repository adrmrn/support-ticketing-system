<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Middleware\CommandBus;

use Doctrine\ORM\EntityManagerInterface;
use League\Tactician\Middleware;

class DoctrineTransactionMiddleware implements Middleware
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
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
            $this->entityManager->commit();
        } catch (\Exception $exception) {
            $this->entityManager->rollback();
            throw $exception;
        }

        return $result;
    }
}