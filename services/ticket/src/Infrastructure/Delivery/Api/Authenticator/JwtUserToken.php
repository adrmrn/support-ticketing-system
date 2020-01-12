<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Delivery\Api\Authenticator;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

class JwtUserToken extends AbstractToken
{
    private string $token;

    public function __construct(string $token)
    {
        parent::__construct();
        $this->token = $token;
    }

    public function __toString(): string
    {
        return $this->token;
    }

    /**
     * @inheritDoc
     */
    public function getCredentials()
    {
        return '';
    }
}