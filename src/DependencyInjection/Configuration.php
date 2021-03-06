<?php
namespace Coa\MaintenanceBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration implements ConfigurationInterface
{
    function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder('coa_maintenance');

        $rootNode = $builder->getRootNode();
        $rootNode
            ->children()

            ->booleanNode('activate')
            ->defaultValue(false)
            ->end()

            ->end();

        return $builder;
    }
}