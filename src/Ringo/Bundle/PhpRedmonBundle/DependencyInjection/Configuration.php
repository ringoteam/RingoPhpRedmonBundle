<?php

/*
 * This file is part of the phpRedmon project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ringo\Bundle\PhpRedmonBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
/**
 * Classe Configuration
 *
 * @author Patrick Deroubaix <patrick.deroubaix@gmail.com>
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
        $rootNode = $treeBuilder->root('ringo_php_redmon');
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