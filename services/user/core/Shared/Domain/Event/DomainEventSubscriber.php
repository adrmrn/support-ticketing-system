<?php
declare(strict_types=1);

namespace User\Core\Shared\Domain\Event;

use User\Core\Shared\Domain\DomainEvent;

interface DomainEventSubscriber
{
    public function isSubscribedTo(DomainEvent $event): bool;
    public function handle(DomainEvent $event): void;
}
