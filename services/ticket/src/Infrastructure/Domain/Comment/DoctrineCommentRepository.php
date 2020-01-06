<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Domain\Comment;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Ramsey\Uuid\Uuid;
use Ticket\Domain\Comment\Comment;
use Ticket\Domain\Comment\CommentId;
use Ticket\Domain\Comment\CommentRepository;
use Ticket\Domain\Exception\CommentNotFound;

class DoctrineCommentRepository implements CommentRepository
{
    private EntityManagerInterface $entityManager;
    private ObjectRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Comment::class);
    }

    public function nextIdentity(): CommentId
    {
        return CommentId::fromString(Uuid::uuid4()->toString());
    }

    public function add(Comment $comment): void
    {
        $this->entityManager->persist($comment);
    }

    /**
     * @inheritDoc
     */
    public function getById(CommentId $id): Comment
    {
        $comment = $this->repository->find($id);
        if (!($comment instanceof Comment)) {
            throw CommentNotFound::withCommentId($id);
        }

        return $comment;
    }
}