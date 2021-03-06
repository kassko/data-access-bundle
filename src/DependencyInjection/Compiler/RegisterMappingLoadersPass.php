<?php

namespace Kassko\Bundle\DataMapperBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RegisterMappingLoadersPass implements CompilerPassInterface
{
    private static $mappingLoaderTag = 'kassko_data_mapper.mapping_loader';

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $loaderResolverDef = $container->getDefinition('kassko_data_mapper.class_metadata_loader.loader_resolver');

        foreach ($container->findTaggedServiceIds(self::$mappingLoaderTag) as $service => $tagAttributes) {
            foreach ($tagAttributes as $attributes) {
                $loaderResolverDef->addMethodCall('addLoader', [new Reference($service)]);
            }
        }
    }
}
