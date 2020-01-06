<?php
declare(strict_types=1);

namespace User\Core\Infrastructure\Middleware;

use Doctrine\ORM\EntityManagerInterface;

class DoctrineTransactionMiddleware
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle($request, \Closure $next)
    {
        try {
            $this->entityManager->beginTransaction();

            $result = $next($request);

            $this->entityManager->flush();
            $this->entityManager->commit();
        } catch (\Exception $exception) {
            $this->entityManager->rollback();
            throw $exception;
        }

        return $result;
    }
}
