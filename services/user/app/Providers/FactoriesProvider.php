<?php
declare(strict_types=1);

namespace App\Providers;

use Doctrine\DBAL\Connection;
use Illuminate\Support\ServiceProvider;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use User\Core\Infrastructure\Middleware\RpcApiKeyAuthenticationMiddleware;
use User\Core\Infrastructure\Persistence\Doctrine\DbalConnectionFactory;

class FactoriesProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(Connection::class, function() {
            return DbalConnectionFactory::create();
        });
        $this->app->bind(AMQPStreamConnection::class, function() {
            // TODO: change default credentials
            return new AMQPStreamConnection('localhost', 5672, 'homestead', 'secret');
        });
        $this->app->bind(RpcApiKeyAuthenticationMiddleware::class, function() {
            // TODO: change default credentials
            return new RpcApiKeyAuthenticationMiddleware(
                (string)env('RPC_AUTH_KEY')
            );
        });
    }
}
