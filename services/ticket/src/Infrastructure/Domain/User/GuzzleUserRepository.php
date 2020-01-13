<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Domain\User;

use GuzzleHttp\Client;
use Ticket\Domain\Exception\UserNotFound;
use Ticket\Domain\User\User;
use Ticket\Domain\User\UserId;
use Ticket\Domain\User\UserRepository;

class GuzzleUserRepository implements UserRepository
{
    private Client $client;
    private string $userServiceUri;
    private string $xRpcAuthKey;

    public function __construct(Client $client, string $userServiceUri, string $xRpcAuthKey)
    {
        $this->client = $client;
        $this->userServiceUri = $userServiceUri;
        $this->xRpcAuthKey = $xRpcAuthKey;
    }

    public function getById(UserId $id): User
    {
        $response = $this->client->get(
            sprintf('%s/user/%s', $this->userServiceUri, (string)$id),
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'X-RPC-AUTH' => $this->xRpcAuthKey
                ]
            ]
        );

        if (200 !== $response->getStatusCode()) {
            throw UserNotFound::withUserId($id);
        }

        return $this->createExternalUser(
            \json_decode($response->getBody()->getContents(), true)
        );
    }

    private function createExternalUser(array $rawData): ExternalUser
    {
        return new ExternalUser(
            $rawData['id'],
            $rawData['firstName'],
            $rawData['lastName'],
            $rawData['role']
        );
    }
}