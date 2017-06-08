<?php

namespace LimetecBiotechnologies\RedmineApiBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class RedmineApiExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        foreach($config['clients'] as $name => $client){
            $this->createClient($name,$client['url'],$client['token'],$container);
        }

        reset($config['clients']);

        $container->setAlias('redmineapi.client.default', sprintf('redmineapi.client.%s', key($config['clients'])));
    }

    private function createClient($name, $url, $token, ContainerBuilder $container){
        $definition = new Definition('%redmine.client.class%', array($url, $token));

        $container->setDefinition(
            sprintf('redmineapi.client.%s', $name),
            $definition
        );
    }
}
