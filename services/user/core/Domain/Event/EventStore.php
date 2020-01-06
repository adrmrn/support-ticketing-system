<?php
declare(strict_types=1);

namespace User\Core\Domain\Event;

interface EventStore
{
    public function append(DomainEvent $event);
}
