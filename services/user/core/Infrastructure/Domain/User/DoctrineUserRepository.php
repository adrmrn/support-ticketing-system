<?php
declare(strict_types=1);

namespace User\Core\Infrastructure\Domain\User;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use User\Core\Domain\Exception\UserNotFound;
use User\Core\Domain\User\User;
use User\Core\Domain\User\UserId;
use User\Core\Domain\User\UserRepository;
use User\Core\Domain\Email;

class DoctrineUserRepository implements UserRepository
{
    private EntityManagerInterface $entityManager;
    private ObjectRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(User::class);
    }

    public function nextIdentity(): UserId
    {
        return UserId::fromString(Uuid::uuid4()->toString());
    }

    public function add(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getById(UserId $id): User
    {
        $user = $this->repository->find($id);
        if (!($user instanceof User)) {
            throw UserNotFound::withUserId($id);
        }

        return $user;
    }

    public function existsByEmail(Email $email): bool
    {
        $user = $this->repository->findBy([
            'email' => $email
        ]);
        return $user instanceof User;
    }
}
