<?php

namespace WebtownPhp\BannerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('webtown_php_banner');

        $rootNode
            ->children()

                ->scalarNode('table_prefix')
                ->end()

                // db driver
                ->enumNode('db_driver')
                    ->values(array('orm', 'odm'))
                    ->isRequired()
                ->end()

                // custom size
                ->arrayNode('custom_size')
                    ->info('Named banner sizes')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()

                            ->integerNode('width')
                                ->min(1)
                                ->isRequired()
                            ->end()

                            ->integerNode('height')
                                ->min(1)
                                ->isRequired()
                            ->end()

                        ->end()
                    ->end()
                ->end()

                // default
                ->arrayNode('default')
                    ->info('Default banner type availability')
                    ->children()
                        ->booleanNode('flash')
                            ->defaultValue(true)
                        ->end()
                        ->booleanNode('img')
                            ->defaultValue(true)
                        ->end()
                        ->booleanNode('html')
                            ->defaultValue(true)
                        ->end()
                    ->end()
                ->end() // default

                // place
                ->arrayNode('place')
                    ->info('Available banner places')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            // label
                            ->scalarNode('label')
                                ->cannotBeEmpty()
                            ->end()
                            // size
                            ->scalarNode('size')
                                ->cannotBeEmpty()
                            ->end()
                            // flash
                            ->booleanNode('flash')
                            ->end()
                            // img
                            ->booleanNode('img')
                            ->end()
                            // html
                            ->booleanNode('html')
                            ->end()
                        ->end()
                    ->end()
                ->end() // place

            ->end()
        ;

        return $treeBuilder;
    }
}
