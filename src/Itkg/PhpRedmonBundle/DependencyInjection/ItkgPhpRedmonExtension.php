<?php

namespace Itkg\PhpRedmonBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;

/**
 * Classe ItkgPhpRedmonExtension
 *
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class ItkgPhpRedmonExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
         $configuration = new Configuration();
         $config = $this->processConfiguration($configuration, $configs);
         
         if (!isset($config['log']['days'])) {
            throw new \InvalidArgumentException('The "itkg_php_redmon.log.days" option must be set');
         }
         $container->setParameter('itkg_php_redmon.log.days', $config['log']['days']);
         $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
         $loader->load('serializer.xml');
         $loader->load('manager.xml');
         $loader->load('worker.xml');
         $loader->load('logger.xml');
    }

    public function getAlias()
    {
        return 'itkg_php_redmon';
    }
}
