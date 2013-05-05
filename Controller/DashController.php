<?php

/*
 * This file is part of the phpRedmon project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ringo\Bundle\PhpRedmonBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Ringo\Bundle\PhpRedmonBundle\Controller\Controller as BaseController;

/**
 * Class DashController
 *
 * @author Patrick Deroubaix <patrick.deroubaix@gmail.com>
 * @author Pascal DENIS <pascal.denis.75@gmail.cerrorom>
 */
class DashController extends BaseController
{
    /**
     * Render choose action or dashboard action
     * 
     * @return mixed
     */
    public function indexAction()
    {
        $instance = $this->getCurrentInstance();
        if($instance) {
            
            $worker = $this->getWorker();
            // Worker can be undefined if server went away
            // For the current instance or if there is no instance selected
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
        }
        
        return new RedirectResponse($this->generateUrl('ringo_php_redmon_instances'));
    }
    
    /**
     * Render client list for the current instance
     * 
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function clientAction()
    {
        $worker = $this->getWorker();
        // Worker can be undefined if server went away
        // For the current instance or if we have no instance selected
        if(!$worker) {
            return new RedirectResponse($this->generateUrl('ringo_php_redmon'));
        }
        return $this->render(
            $this->getTemplatePath().'client.html.twig',
            array(
                'instance' => $worker->getInstance(),
                'clients'=> $worker->getClients()
            )
        );
    }
    
    /**
     * Render configuration list for the current instance
     * 
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function configurationAction()
    {
        $worker = $this->getWorker();
        // Worker can be undefined if server went away
        // For the current instance or if we have no instance selected
        if(!$worker) {
            return new RedirectResponse($this->generateUrl('ringo_php_redmon'));
        }
        
        return $this->render(
            $this->getTemplatePath().'configuration.html.twig',
            array(
                'instance' => $worker->getInstance(),
                'configs'  => $worker->getConfiguration()
            )
        );
    }
    
    /**
     * Select action
     * Change the current instance
     * 
     * @param string $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function selectAction($id)
    {
        $instance = $this->getManager()->find($id);
        // If instance exists
        if($instance) {
            $this->getRequest()->getSession()->set('instance', $instance);
            if($this->getWorker()) {
                $this->get('session')->setFlash('success', 'Instance '.$instance->getName().' selected');
            }else {
                $this->get('session')->setFlash('error', 'Instance '.$instance->getName().' cannot be selected');
            }
        }else {
            $this->get('session')->setFlash('error', 'This instance does not exist');
        }
        
        return new RedirectResponse($this->generateUrl('ringo_php_redmon'));
    }
    
    /**
     * Get template path for this controller
     * 
     * @return string
     */
    protected function getTemplatePath()
    {
        return 'RingoPhpRedmonBundle:Dash:';
    }
}