<?php
declare(strict_types=1);

namespace App\Services;

use App\Events\EventBus;
use App\Events\UserRegistered\UserRegisteredEvent;
use App\Models\ExternalEvent;
use PhpAmqpLib\Message\AMQPMessage;

class MessageReceiver
{
    private MessageConsumer $messageConsumer;
    private EventBus $eventBus;

    public function __construct(MessageConsumer $messageConsumer, EventBus $eventBus)
    {
        $this->messageConsumer = $messageConsumer;
        $this->eventBus = $eventBus;
    }

    public function receiveMessages(string $exchangeName): void
    {
        $this->messageConsumer->open($exchangeName);
        echo " [*] Waiting for logs. To exit press CTRL+C\n";
        $this->messageConsumer->consume($exchangeName, [$this, 'handleMessage']);
        $this->messageConsumer->close();
    }

    public function handleMessage(AMQPMessage $message): void
    {
        $externalEvent = ExternalEvent::fromJson($message->body);
        echo " [*] Received event: " . $externalEvent->type() . "\n";
        $event = null;
        $externalEventBody = $externalEvent->body();
        switch ($externalEvent->type()) {
            case 'user.user_registered':
                $event = new UserRegisteredEvent(
                    $externalEventBody['id'],
                    $externalEventBody['email'],
                    $externalEventBody['hashedPassword']
                );
                break;

            default:
                return;
        }

        $this->eventBus->handle($event);
    }
}
