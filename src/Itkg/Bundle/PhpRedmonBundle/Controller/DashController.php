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
            
            $worker = $this->getWorker()->setInstance($instance);
            
            if($worker->ping()) {
                $infos = $worker->getInfos();
                
                $slowLogs = $worker->getSlowLogs();
                $keySpace = $worker->getKeyspace();
                
                return $this->render(
                    $this->getTemplatePath().'index.html.twig',
                    array(
                        'instance' => $instance,
                        'infos'    => $infos,
                        'slowLogs'  => $slowLogs,
                        'keyspace'  => $keySpace
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
        $instance = $this->getCurrentInstance();
        
        $worker = $this->getWorker()->setInstance($instance);
        $clients = $worker->getClients();
        
        return $this->render(
            $this->getTemplatePath().'client.html.twig',
            array(
                'instance' => $instance,
                'clients'=> $clients
            )
        );
    }
    
    public function configurationAction()
    {
        $instance = $this->getCurrentInstance();
        
        $worker = $this->getWorker()->setInstance($instance);
        $configs = $worker->getConfiguration();
        
        return $this->render(
            $this->getTemplatePath().'configuration.html.twig',
            array(
                'instance' => $instance,
                'configs'=> $configs
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