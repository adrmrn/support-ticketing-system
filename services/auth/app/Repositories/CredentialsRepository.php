<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Exceptions\CredentialsNotFound;
use App\Models\Credentials;
use App\Models\Email;

interface CredentialsRepository
{
    /**
     * @param Email $email
     * @return Credentials
     * @throws CredentialsNotFound
     */
    public function getByEmail(Email $email): Credentials;

    public function doesEmailExist(Email $email): bool;

    public function store(Credentials $credentials): void;
}
