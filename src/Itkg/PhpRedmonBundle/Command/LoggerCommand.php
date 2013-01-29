<?php

namespace Itkg\PhpRedmonBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Classe Command
 *
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class LoggerCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('itkg_php_redmon:log')
            ->setDescription('Log Redis instance');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $logger = $this->getContainer()->get('itkg_php_redmon.instance_logger');
        $manager = $this->getContainer()->get('itkg_php_redmon.instance_manager');
        $instances = $manager->findAll();
        
        if(is_array($instances)) {
            foreach($instances as $instance) {
                $logger
                    ->setInstance($instance)
                    ->execute();
            }
        }
    }
}