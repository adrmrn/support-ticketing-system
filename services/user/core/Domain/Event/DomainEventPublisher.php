<?php
declare(strict_types=1);

namespace User\Core\Domain\Event;

final class DomainEventPublisher
{
    /**
     * @var DomainEventSubscriber[]
     */
    private array $subscribers = [];
    private static ?DomainEventPublisher $instance = null;

    public static function instance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function publish(DomainEvent $event)
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

    public function __clone()
    {
        throw new \BadMethodCallException('Clone is not supported.');
    }
}
