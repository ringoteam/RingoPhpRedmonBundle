<?php

namespace Itkg\PhpRedmonBundle\Controller;

use Itkg\PhpRedmonBundle\Form\InstanceType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Itkg\PhpRedmonBundle\Controller\Controller as BaseController;

/**
 * Classe DashController
 *
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class DashController extends BaseController
{
    public function indexAction()
    {
        if($instance = $this->getCurrentInstance()) {
            // Update of instance to have last logs created
            $instance = $this->getManager->find($instance->getId());
            $worker = $this->getWorker()->setInstance($instance);
            $worker->ping();
            $worker->getInfos();
            
            return $this->render(
               $this->getTemplatePath().'index.html.twig',
               array(
                   'instance' => $instance
               )
            );
        }
        
        return $this->render(
            $this->getTemplatePath().'choose.html.twig',
            array(
                'instances' => $this->getManager()->findAll()
            )
         );
    }
    
    public function selectAction($id)
    {
        $instance = $this->getManager()->find($id);
        if($instance) {
            $this->getRequest()->getSession()->set('instance', $instance);
        }
        
        return new RedirectResponse($this->generateUrl('itkg_php_redmon'));
    }
    
    protected function getTemplatePath()
    {
        return 'ItkgPhpRedmonBundle:Dash:';
    }
}