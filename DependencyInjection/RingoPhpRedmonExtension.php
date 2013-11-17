<?php

/*
 * This file is part of the phpRedmon project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ringo\Bundle\PhpRedmonBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;

/**
 * Classe RingoPhpRedmonExtension
 *
 * @author Patrick Deroubaix <patrick.deroubaix@gmail.com>
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class RingoPhpRedmonExtension extends Extension
{
    /**
     * Load configuration of Bundle
     * 
     * @param array $configs Configuration parameters
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     * @throws \InvalidArgumentException
     */
    public function load(array $configs, ContainerBuilder $container)
    {
         $configuration = new Configuration();
         $config = $this->processConfiguration($configuration, $configs);
         
         if (!isset($config['log']['days'])) {
            throw new \InvalidArgumentException('The "ringo_php_redmon.log.days" option must be set');
         }
         $container->setParameter('ringo_php_redmon.log.days', $config['log']['days']);
         $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
         $loader->load('entity.xml');
         $loader->load('form.xml');
         $loader->load('manager.xml');
         $loader->load('worker.xml');
         $loader->load('logger.xml');
         $loader->load('model.xml');
    }

    /**
     * 
     * @return string Extension's alias
     */
    public function getAlias()
    {
        return 'ringo_php_redmon';
    }
}
