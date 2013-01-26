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
         $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
         $loader->load('serializer.xml');
         $loader->load('manager.xml');
    }

    public function getAlias()
    {
        return 'itkg_php_redmon';
    }
}
