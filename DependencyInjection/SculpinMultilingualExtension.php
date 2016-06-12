<?php

namespace Rocketage\Sculpin\Bundle\MultilingualBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Sculpin Redirect Extension.
 *
 * @author Marco Vito Moscaritolo <marco@mavimo.org>
 */
class SculpinMultilingualExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration;
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $container->setParameter('sculpin_multilingual.config.shared_directory', $config['shared_directory']);
        $container->setParameter('sculpin_multilingual.config.target_directories', $config['target_directories']);
    }
}
