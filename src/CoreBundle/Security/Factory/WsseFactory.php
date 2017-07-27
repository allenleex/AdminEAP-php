<?php
/**
* @copyright Copyright (c) 2008 – 2017 www.08cms.com
* @author 08cms项目开发团队
* @package 08cms
* create date 2017年7月3日
*/
namespace CoreBundle\Security\Factory;

use CoreBundle\Security\Provider\WsseProvider;
use CoreBundle\Security\Firewall\WsseListener;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\SecurityFactoryInterface;

class WsseFactory implements SecurityFactoryInterface
{
    public function create(ContainerBuilder $container, $id, $config, $userProvider, $defaultEntryPoint)
    {
        $providerId = 'security.authentication.provider.wsse.'.$id;

        $container
            ->setDefinition($providerId, new ChildDefinition(WsseProvider::class))
            ->replaceArgument(0, new Reference($userProvider))
            ->replaceArgument(2, $config['lifetime']);
    
        $listenerId = 'security.authentication.listener.wsse.'.$id;
        $container->setDefinition($listenerId, new ChildDefinition(WsseListener::class));
    
        return array($providerId, $listenerId, $defaultEntryPoint);
    }
    
    public function getPosition()
    {
        return 'pre_auth';
    }
    
    public function getKey()
    {
        return 'wsse';
    }
    
    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('lifetime')->defaultValue(300)
            ->end();
    }
}