<?php

/*
 * This file is part of the phpRedmon project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itkg\Bundle\PhpRedmonBundle\Controller;

use Itkg\Bundle\PhpRedmonBundle\Form\InstanceType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;

/**
 * Classe Controller
 *
 * @author Patrick Deroubaix <patrick.deroubaix@gmail.com>
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class Controller extends BaseController
{
    public function getManager()
    {
        return $this->get('itkg_php_redmon.instance_manager');
    }
    
    public function getCurrentInstance()
    {
        $instance = $this->getRequest()->getSession()->get('instance');
        
        if($instance) {
            // Update of instance to have last logs created
            $instance = $this->getManager()->find($instance->getId());
        }
        return $instance;
        
    }
    
    protected function getWorker()
    {
        return $this->get('itkg_php_redmon.instance_worker');
    }
}