<?php

namespace WebtownPhp\BannerBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class WebtownPhpBannerExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $configMerged = $this->processConfiguration($configuration, $configs);
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('defaults.yml');
        $loader->load('services.yml');

        $container->setParameter('webtown_php_banner', $configMerged);
        // create service alias
        $driver = $configMerged['db_driver'];
        $service = sprintf('webtown_php_banner.%s.manager', $driver);
        $container->setAlias('webtown_php_banner.manager', $service);
    }
}
