<?php
declare(strict_types=1);

namespace App\Providers;

use App\Events\EventBus;
use App\Events\UserRegistered\UserRegisteredEvent;
use App\Events\UserRegistered\UserRegisteredHandler;
use App\Factories\DbalConnectionFactory;
use App\Factories\EventBusFactory;
use App\Services\JwtService;
use App\Services\TokenService;
use Doctrine\DBAL\Connection;
use Illuminate\Support\ServiceProvider;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class FactoryProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(Connection::class, function () {
            return DbalConnectionFactory::create();
        });
        $this->app->bind(TokenService::class, function () {
            if (empty(env('JWT_SECRET')) ||
                empty(env('JWT_ISSUER')) ||
                empty(env('JWT_EXPIRATION_TIME'))
            ) {
                throw new \RuntimeException('Missing JWT configuration.');
            }

            return new JwtService(
                env('JWT_SECRET'),
                env('JWT_ISSUER'),
                (int)env('JWT_EXPIRATION_TIME')
            );
        });
        $this->app->singleton(EventBus::class, function ($app) {
            $eventHandlers = [
                UserRegisteredEvent::class => $this->app->get(UserRegisteredHandler::class)
            ];
            return EventBusFactory::create($eventHandlers);
        });
        $this->app->bind(AMQPStreamConnection::class, function() {
            // TODO: change default credentials
            return new AMQPStreamConnection('localhost', 5672, 'homestead', 'secret');
        });
    }
}
