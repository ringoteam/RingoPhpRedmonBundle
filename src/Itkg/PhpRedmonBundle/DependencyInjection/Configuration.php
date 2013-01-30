<?php

namespace Itkg\PhpRedmonBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
/**
 * Classe Configuration
 *
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('itkg_php_redmon');
        $rootNode
            ->children()
                ->arrayNode('log')
                    ->children()
                        ->scalarNode('days')->isRequired()->end()
                    ->end()
                ->end()
            ->end();
       
        return $treeBuilder;
    }
}