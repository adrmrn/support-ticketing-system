<?php
declare(strict_types=1);

namespace User\Core\Infrastructure\Delivery\Api\Event;

use User\Core\Domain\Event\DomainEvent;
use User\Core\Domain\Event\DomainEventSubscriber;
use User\Core\Domain\User\UserRegistered;

class RegisteredUserIdSubscriber implements DomainEventSubscriber
{
    private ?string $userId = null;

    public function userId(): ?string
    {
        return $this->userId;
    }

    public function handle(DomainEvent $event): void
    {
        $this->userId = $event->aggregateId();
    }

    public function isSubscribedTo(DomainEvent $event): bool
    {
        return ($event instanceof UserRegistered);
    }
}
