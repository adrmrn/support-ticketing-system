<?php
declare(strict_types=1);

namespace Ticket\Infrastructure\Delivery\Api\Authenticator;

use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\SecurityFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class JwtFactory implements SecurityFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function create(
        ContainerBuilder $container,
        string $id,
        array $config,
        string $userProvider,
        ?string $defaultEntryPoint
    ) {
        $providerId = 'security.authentication.provider.jwt.' . $id;
        $container->setDefinition($providerId, new ChildDefinition(JwtProvider::class));

        $listenerId = 'security.authentication.listener.jwt.' . $id;
        $container->setDefinition($listenerId, new ChildDefinition(JwtListener::class));

        return [$providerId, $listenerId, $defaultEntryPoint];
    }

    /**
     * @inheritDoc
     */
    public function getPosition()
    {
        return 'pre_auth';
    }

    /**
     * @inheritDoc
     */
    public function getKey()
    {
        return 'jwt';
    }

    public function addConfiguration(NodeDefinition $builder)
    {
        // do nothing
    }
}