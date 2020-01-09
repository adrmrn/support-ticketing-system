<?php
declare(strict_types=1);

namespace App\Providers;

use App\Repositories\CredentialsRepository;
use App\Repositories\MySqlCredentialsRepository;
use App\Services\BcryptPasswordVerifier;
use App\Services\JwtService;
use App\Services\PasswordVerifier;
use App\Services\TokenService;
use Illuminate\Support\ServiceProvider;

class ContractProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(CredentialsRepository::class, MySqlCredentialsRepository::class);
        $this->app->bind(PasswordVerifier::class, BcryptPasswordVerifier::class);
    }
}
