<?php
declare(strict_types=1);

namespace App\Providers;

use App\Factories\DbalConnectionFactory;
use App\Services\JwtService;
use App\Services\TokenService;
use Doctrine\DBAL\Connection;
use Illuminate\Support\ServiceProvider;

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
    }
}
