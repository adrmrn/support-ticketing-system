<?php
declare(strict_types=1);

namespace App\Providers;

use Doctrine\DBAL\Driver\Connection;
use Illuminate\Support\ServiceProvider;
use User\Core\Infrastructure\Persistence\Doctrine\DbalConnectionFactory;

class FactoriesProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(Connection::class, function() {
            return DbalConnectionFactory::create();
        });
    }
}
