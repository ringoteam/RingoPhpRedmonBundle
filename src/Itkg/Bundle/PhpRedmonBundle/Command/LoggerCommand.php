<?php

/*
 * This file is part of the phpRedmon project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itkg\Bundle\PhpRedmonBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Classe Command
 * 
 * This command logs instances
 * 
 * @author Patrick Deroubaix <patrick.deroubaix@gmail.com>
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class LoggerCommand extends ContainerAwareCommand
{
    /**
     * Configure 
     */
    protected function configure()
    {
        $this
            ->setName('itkg_php_redmon:log')
            ->setDescription('Log Redis instance');
    }

    /**
     * Execute task 
     * Get all redis instances and log some of infos
     * 
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
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