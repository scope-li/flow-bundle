<?php

declare(strict_types=1);

namespace Scopeli\FlowBundle;

use Override;
use Scopeli\FlowBundle\Connector\ConnectorInterface;
use Scopeli\FlowBundle\Process\ProcessDefinitionRepositoryInterface;
use Scopeli\FlowBundle\Process\ProcessInstanceRepositoryInterface;
use Scopeli\FlowBundle\Script\ScriptInterface;
use Scopeli\FlowBundle\Serializer\SerializerInterface;
use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class ScopeliFlowBundle extends AbstractBundle
{
    #[Override]
    public function getPath(): string
    {
        return __DIR__;
    }

    public function configure(DefinitionConfigurator $definition): void
    {
        $definition->rootNode()
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
    }

    /**
     * @param array<string, mixed> $config
     */
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->import('Resources/config/services.xml');

        /** @var array{process_instance: array{repository: string, serializer: string}, process_definition: array{repository: string}} $config */
        $builder->setAlias(ProcessInstanceRepositoryInterface::class, $config['process_instance']['repository']);
        $builder->setAlias(SerializerInterface::class, $config['process_instance']['serializer']);
        $builder->setAlias(ProcessDefinitionRepositoryInterface::class, $config['process_definition']['repository']);

        $builder->registerForAutoconfiguration(ConnectorInterface::class)
            ->addTag('scopeli_flow.connector');

        $builder->registerForAutoconfiguration(ScriptInterface::class)
            ->addTag('scopeli_flow.script');
    }
}
