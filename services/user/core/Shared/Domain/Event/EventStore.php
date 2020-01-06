<?php
declare(strict_types=1);

namespace User\Core\Shared\Domain\Event;

use User\Core\Shared\Domain\DomainEvent;

interface EventStore
{
    public function append(DomainEvent $event);
}
