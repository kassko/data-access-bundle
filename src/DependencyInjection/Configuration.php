<?php

namespace Kassko\Bundle\DataMapperBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder();
        $rootNode = $builder->root('kassko_data_mapper');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('logger_service')->end()
                ->arrayNode('cache')->addDefaultsIfNotSet()
                    ->append($this->addCacheNode('metadata_cache'))
                    ->append($this->addCacheNode('result_cache'))
                ->end()
                ->arrayNode('mapping')->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('default_resource_type')->defaultValue('annotations')->end()
                        ->scalarNode('default_resource_dir')->end()
                        ->scalarNode('default_provider_method')->end()
                        ->arrayNode('bundles')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('resource_type')->end()
                                    ->scalarNode('resource_dir')->end()
                                    ->scalarNode('provider_method')->end()

                                    ->arrayNode('entities')
                                        ->prototype('array')
                                            ->children()
                                                ->scalarNode('resource_type')->end()
                                                ->scalarNode('resource_path')->end()
                                                ->scalarNode('resource_name')->end()
                                                ->scalarNode('provider_method')->end()
                                                ->scalarNode('entity_class')->isRequired()->end()
                                            ->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $builder;
    }

    private function addCacheNode($name)
    {
        $builder = new TreeBuilder();
        $node = $builder->root($name);

        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('class')->end()
                ->scalarNode('id')->end()
                ->scalarNode('life_time')->defaultValue(0)->end()
                ->booleanNode('is_shared')->defaultFalse()->end()
                ->scalarNode('adapter_class')->defaultValue('Kassko\Bundle\DataMapperBundle\Adapter\Cache\DoctrineCacheAdapter')->end()
            ->end()
        ;

        return $node;
    }
}
