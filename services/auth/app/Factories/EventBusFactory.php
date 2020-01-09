<?php
declare(strict_types=1);

namespace App\Factories;

use App\Events\EventBus;

class EventBusFactory
{
    public static function create(array $eventHandlers = []): EventBus
    {
        $eventBus = new EventBus();
        foreach ($eventHandlers as $eventClass => $handler) {
            $eventBus->addEventHandler($eventClass, $handler);
        }

        return $eventBus;
    }
}
