<?php

namespace Scopeli\FlowBundle\DependencyInjection;

use Scopeli\FlowBundle\Connector\ConnectorInterface;
use Scopeli\FlowBundle\Process\ProcessDefinitionRepositoryInterface;
use Scopeli\FlowBundle\Process\ProcessInstanceRepositoryInterface;
use Scopeli\FlowBundle\Script\ScriptInterface;
use Scopeli\FlowBundle\Serializer\SerializerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class ScopeliFlowExtension extends Extension
{
    /**
     * @param string[] $configs
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        $loader = new XmlFileLoader($container, new FileLocator(dirname(__DIR__).'/Resources/config'));
        $loader->load('services.xml');

        $this->configureInterfaceAlias($config, $container);

        $container->registerForAutoconfiguration(ConnectorInterface::class)
            ->addTag('scopeli_flow.connector');

        $container->registerForAutoconfiguration(ScriptInterface::class)
            ->addTag('scopeli_flow.script');
    }

    private function configureInterfaceAlias(array $config, ContainerBuilder $container): void
    {
        // ProcessInstanceRepositoryInterface.
        $container->setAlias(ProcessInstanceRepositoryInterface::class, $config['process_instance']['repository']);

        // SerializerInterface.
        $container->setAlias(SerializerInterface::class, $config['process_instance']['serializer']);

        // ProcessDefinitionRepositoryInterface.
        $container->setAlias(ProcessDefinitionRepositoryInterface::class, $config['process_definition']['repository']);
    }
}
