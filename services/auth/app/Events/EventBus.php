<?php
declare(strict_types=1);

namespace App\Events;

use App\Exceptions\HandlerForEventNotFound;

class EventBus
{
    private array $handlers = [];

    public function addEventHandler(string $eventClass, callable $handler): void
    {
        $this->handlers[$eventClass] = $handler;
    }

    public function handle(Event $event): void
    {
        $eventClass = \get_class($event);
        if (!array_key_exists($eventClass, $this->handlers)) {
            throw new HandlerForEventNotFound();
        }

        call_user_func($this->handlers[$eventClass], $event);
    }
}
