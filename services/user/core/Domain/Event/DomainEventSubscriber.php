<?php
declare(strict_types=1);

namespace User\Core\Domain\Event;

interface DomainEventSubscriber
{
    public function handle(DomainEvent $event): void;
    public function isSubscribedTo(DomainEvent $event): bool;
}
