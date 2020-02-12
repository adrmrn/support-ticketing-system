<?php
declare(strict_types=1);

namespace Ticket\Tests\Support\MotherObject\Domain\Event;

use Ticket\Domain\Event\DomainEventDispatcher;
use Ticket\Domain\Event\DomainEventSubscriber;

class DomainEventDispatcherMother
{
    public static function createWithSubscribers(DomainEventSubscriber ...$subscribers): DomainEventDispatcher
    {
        $domainEventDispatcher = new DomainEventDispatcher();
        foreach ($subscribers as $subscriber) {
            $domainEventDispatcher->subscribe($subscriber);
        }

        return $domainEventDispatcher;
    }
}