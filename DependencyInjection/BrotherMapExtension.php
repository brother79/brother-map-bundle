<?php

namespace Brother\MapBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class BrotherMapExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        // get all Bundles
        $brotherConfig = array();

        // add the BrotherMapBundle configurations
        // all options can be overridden in the app/config/config.yml file
        $container->prependExtensionConfig('brother_map', $brotherConfig);
    }

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('brother_map.yandex.html_id', $config['yandex']['html_id']);
        $container->setParameter('brother_map.yandex.zoom', $config['yandex']['zoom']);
        $container->setParameter('brother_map.yandex.type', $config['yandex']['type']);

        $container->setParameter('brother_map.google.html_id', $config['google']['html_id']);
        $container->setParameter('brother_map.google.zoom', $config['google']['zoom']);
        $container->setParameter('brother_map.google.type', $config['google']['type']);
    }
}
