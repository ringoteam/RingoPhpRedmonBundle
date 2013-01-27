<?php

namespace Itkg\PhpRedmonBundle\Controller;

use Itkg\PhpRedmonBundle\Form\InstanceType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;

/**
 * Classe Controller
 *
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
        return $this->getRequest()->getSession()->get('instance');
    }
    
    protected function getWorker()
    {
        return $this->get('itkg_php_redmon.instance_worker');
    }
}