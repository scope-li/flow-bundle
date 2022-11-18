<?php

namespace Scopeli\FlowBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('scopeli_flow');
        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('process_instance')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('repository')
                            ->defaultValue('scopeli_flow.process.process_instance_repository')
                        ->end()
                        ->scalarNode('serializer')
                            ->defaultValue('scopeli_flow.serializer.base64_php_serializer')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('process_definition')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('repository')
                            ->defaultValue('scopeli_flow.serializer.base64_php_serializer')
                        ->end()
                    ->end()
                ->end()
            ->end()
            ;

        return $treeBuilder;
    }
}
