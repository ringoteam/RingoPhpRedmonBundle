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
use Itkg\Bundle\PhpRedmonBundle\Controller\Controller as BaseController;

/**
 * Classe AdminController
 *
 * @author Patrick Deroubaix <patrick.deroubaix@gmail.com>
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class AdminController extends BaseController
{
    public function indexAction()
    {
        
    }
    
    public function flushAllAction()
    {
        try {
            $this->getWorker()->execute('flushAll');
            
            $this->get('session')->setFlash('success', 'Flush ALL executed successfully');
        }catch(\Exception $e) {
            $this->get('session')->setFlash('success', 'We have encountered an error : '.$e->getMessage());
        }
        
        return new RedirectResponse($this->generateUrl('itkg_php_redmon'));
    }
    
    public function flushDbAction($id)
    {
        try {
            $worker = $this->getWorker()->flushDB($id);
            
            $this->get('session')->setFlash('success', 'Flush DB on '.$worker->getInstance()->getDatabase($id)->getName().' executed successfully');
        }catch(\Exception $e) {
            $this->get('session')->setFlash('success', 'Une erreur s\'est produite : '.$e->getMessage());
        }
        
        return new RedirectResponse($this->generateUrl('itkg_php_redmon'));
    }
    
    protected function getTemplatePath()
    {
        return 'ItkgPhpRedmonBundle:Admin:';
    }
}