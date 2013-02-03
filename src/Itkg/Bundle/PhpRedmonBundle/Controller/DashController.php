<?php

/*
 * This file is part of the phpRedmon project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itkg\Bundle\PhpRedmonBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Itkg\Bundle\PhpRedmonBundle\Controller\Controller as BaseController;

/**
 * Classe DashController
 *
 * @author Patrick Deroubaix <patrick.deroubaix@gmail.com>
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class DashController extends BaseController
{
    public function indexAction()
    {
        $instance = $this->getCurrentInstance();
        if($instance) {
            
            $worker = $this->getWorker();
            
            if($worker) {
                
                return $this->render(
                    $this->getTemplatePath().'index.html.twig',
                    array(
                        'instance' => $worker->getInstance(),
                        'infos'    => $worker->getInfos(),
                        'slowLogs'  => $worker->getSlowLogs(),
                        'keyspace'  => $worker->getKeyspace()
                    )
                );
            }
            
            // @TODO gestion erreur
            return $this->render(
                $this->getTemplatePath().'error.html.twig',
                array(
                    'instance' => $instance,
                )
            );
        }
        
        $instances = $this->getManager()->findAll();
        $worker = $this->get('itkg_php_redmon.instance_worker');
        if(is_array($instances)) {
            foreach($instances as $index => $instance) {
                $working = $worker->setInstance($instance)->ping();
                $instances[$index]->setWorking($working);
                $instances[$index]->setError($worker->getMessage());
            }
        }
        
        return $this->render(
            $this->getTemplatePath().'choose.html.twig',
            array(
                'instances' => $instances 
            )
         );
    }
    
    public function clientAction()
    {
        $worker = $this->getWorker();
        if(!$worker) {
            return new RedirectResponse($this->generateUrl('itkg_php_redmon'));
        }
        return $this->render(
            $this->getTemplatePath().'client.html.twig',
            array(
                'instance' => $worker->getInstance(),
                'clients'=> $worker->getClients()
            )
        );
    }
    
    public function configurationAction()
    {
        $worker = $this->getWorker();
        if(!$worker) {
            return new RedirectResponse($this->generateUrl('itkg_php_redmon'));
        }
        
        return $this->render(
            $this->getTemplatePath().'configuration.html.twig',
            array(
                'instance' => $worker->getInstance(),
                'configs'  => $worker->getConfiguration()
            )
        );
    }
    
    
    public function selectAction($id)
    {
        $instance = $this->getManager()->find($id);
        if($instance) {
            $this->getRequest()->getSession()->set('instance', $instance);
            $this->get('session')->setFlash('success', 'Instance '.$instance->getName().' selected');
        }else {
            $this->get('session')->setFlash('error', 'This instance does not exist');
        }
        
        return new RedirectResponse($this->generateUrl('itkg_php_redmon'));
    }
    
    protected function getTemplatePath()
    {
        return 'ItkgPhpRedmonBundle:Dash:';
    }
}