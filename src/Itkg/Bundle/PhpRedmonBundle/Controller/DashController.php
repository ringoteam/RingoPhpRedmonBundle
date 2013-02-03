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
            
            if($worker->ping()) {
                
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
        
        return $this->render(
            $this->getTemplatePath().'choose.html.twig',
            array(
                'instances' => $this->getManager()->findAll()
            )
         );
    }
    
    public function clientAction()
    {
        $worker = $this->getWorker();
        
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