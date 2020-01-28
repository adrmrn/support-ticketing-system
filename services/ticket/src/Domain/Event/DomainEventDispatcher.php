<?php
declare(strict_types=1);

namespace Ticket\Domain\Event;

final class DomainEventDispatcher
{
    /**
     * @var DomainEventSubscriber[]
     */
    private array $subscribers = [];

    public function dispatch(DomainEvent $event)
    {
        foreach ($this->subscribers as $subscriber) {
            if ($subscriber->isSubscribedTo($event)) {
                $subscriber->handle($event);
            }
        }
    }

    public function subscribe(DomainEventSubscriber $subscriber): void
    {
        $this->subscribers[] = $subscriber;
    }
}