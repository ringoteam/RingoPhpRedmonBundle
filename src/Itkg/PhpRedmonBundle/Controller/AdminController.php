<?php

namespace Itkg\PhpRedmonBundle\Controller;

use Itkg\PhpRedmonBundle\Form\InstanceType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Itkg\PhpRedmonBundle\Controller\Controller as BaseController;

/**
 * Classe AdminController
 *
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
            $this->getWorker()->setInstance(
                $this->getCurrentInstance()
            )->execute('flushAll');
            
            $this->get('session')->setFlash('success', 'Flush ALL effectué avec succès');
        }catch(\Exception $e) {
            $this->get('session')->setFlash('success', 'Une erreur s\'est produite : '.$e->getMessage());
        }
        
        return new RedirectResponse($this->generateUrl('itkg_php_redmon'));
    }
    
    public function flushDbAction($id)
    {
        $instance = $this->getCurrentInstance();
        try {
            $this->getWorker()->setInstance(
                $instance
            )->flushDB($id);
            
            $this->get('session')->setFlash('success', 'Flush DB sur '.$instance->getDatabase($id)->getName().' effectué avec succès');
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