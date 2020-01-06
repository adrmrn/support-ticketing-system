<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Domain\Category;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Ramsey\Uuid\Uuid;
use Ticket\Domain\Category\Category;
use Ticket\Domain\Category\CategoryId;
use Ticket\Domain\Category\CategoryRepository;
use Ticket\Domain\Exception\CategoryNotFound;

class DoctrineCategoryRepository implements CategoryRepository
{
    private EntityManagerInterface $entityManager;
    private ObjectRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Category::class);
    }

    public function nextIdentity(): CategoryId
    {
        return CategoryId::fromString(
            Uuid::uuid4()->toString()
        );
    }

    public function add(Category $category): void
    {
        $this->entityManager->persist($category);
    }

    /**
     * @inheritDoc
     */
    public function getById(CategoryId $id): Category
    {
        $category = $this->repository->find($id);
        if (!($category instanceof Category)) {
            throw CategoryNotFound::withCategoryId($id);
        }
        
        return $category;
    }
}