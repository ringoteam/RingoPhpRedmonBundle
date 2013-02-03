<?php

/*
 * This file is part of the phpRedmon project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itkg\Bundle\PhpRedmonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;

/**
 * Class Controller
 * 
 * Contains some usefull methods for childrend controllers
 * 
 * @author Patrick Deroubaix <patrick.deroubaix@gmail.com>
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class Controller extends BaseController
{
    /**
     * Get instance manager
     * 
     * @return mixed
     */
    public function getManager()
    {
        return $this->get('itkg_php_redmon.instance_manager');
    }
    
    /**
     * Get the current instance if exists
     * 
     * @return mixed
     */
    public function getCurrentInstance()
    {
        $instance = $this->getRequest()->getSession()->get('instance');
        
        if($instance) {
            // Update of instance to have last logs created
            $instance = $this->getManager()->find($instance->getId());
        }
        return $instance;
    }
    
    /**
     * Get instance worker initialized with current instance
     * 
     * @return boolean
     */
    protected function getWorker()
    {
        $instance = $this->getCurrentInstance();
        if($instance) {
            // Initialized with the current instance
            
            $worker = $this->get('itkg_php_redmon.instance_worker')->setInstance($instance);
            // We return worker only if the server is up
            if($worker->ping()) {
                return $worker;
            }
            // If we can't ping the server, current instance is removed from session
            $this->getRequest()->getSession()->set('instance', null);
            
            return false;
        }
        return false;
    }
}