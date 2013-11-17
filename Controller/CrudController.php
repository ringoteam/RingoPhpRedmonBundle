<?php

/*
 * This file is part of the phpRedmon project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ringo\Bundle\PhpRedmonBundle\Controller;

use Ringo\Bundle\PhpRedmonBundle\Form\InstanceType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Ringo\Bundle\PhpRedmonBundle\Controller\Controller as BaseController;

/**
 * Classe CrudController
 *
 * @author Patrick Deroubaix <patrick.deroubaix@gmail.com>
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class CrudController extends BaseController
{
    
    /**
     * List of instances action
     * 
     * @return mixed
     */
    public function indexAction()
    {
        // Get all instances
        $instances = $this->getManager()->findAll();
        
        $worker = $this->get('ringo_php_redmon.instance_worker');
        if(is_array($instances)) {
            foreach($instances as $index => $instance) {
                // Ping server and get potential error message
                $working = $worker->setInstance($instance)->ping();
                $instances[$index]->setWorking($working);
                $instances[$index]->setError($worker->getMessage());
            }
        }
        
        return $this->render(
            $this->getTemplatePath().'index.html.twig',
            array(
                'instances' => $instances 
            )
        );
    }
    
    
    /**
     * New instance action
     * 
     * @return mixed
     */
    public function newAction()
    {
        return $this->render(
            $this->getTemplatePath().'new.html.twig',
            array(
                'form' => $this->getForm()->createView(),
                'errors' => array()
            )
        );
    }

    /**
     * Create instance action
     * 
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction()
    {
        $form = $this->getForm();

        $request = $this->get('request');
        if ('POST' == $request->getMethod()) {
            $form->bind($request);
            if ($form->isValid()) {
                
                $this->getManager()->create($form->getData());
                $this->get('session')->setFlash('success', 'Instance Redis created successfully');

                return new RedirectResponse($this->generateUrl('ringo_php_redmon'));
            }else {
                $this->get('session')->setFlash('error', 'Some errors have been found');

            }
        }
        
        return $this->render(
            $this->getTemplatePath().'new.html.twig',
            array(
                'form' => $form->createView(),
                'errors' => $form->getErrors()
            )
        );
    }
    
    /**
     * Edit instance action
     * 
     * @param string $id The instance ID
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction($id)
    {
        $instance = $this->getManager()->find($id);
        if(!$instance) {
            return new RedirectResponse($this->generateUrl('ringo_php_redmon'));
        }
        $form = $this->getForm($instance);
        return $this->render(
            $this->getTemplatePath().'edit.html.twig',
            array(
                'form' => $form->createView(),
                'id'   => $id,
                'errors' => array()
            )
        );
    }
    
    /**
     * Update instance action
     * 
     * @param string $id The instance ID
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateAction($id)
    {
        $form = $this->getForm();
        // Get request
        $request = $this->get('request');
        if ('POST' == $request->getMethod()) {
            $form->bind($request);
            
            if ($form->isValid()) {
                // Save instance
                $this->getManager()->create($form->getData());
                $this->get('session')->setFlash('success', 'Instance Redis updated successfully');

                return new RedirectResponse($this->generateUrl('ringo_php_redmon'));
            }else {
                $this->get('session')->setFlash('error', 'Some errors found');
            }
        }
        
        return $this->render(
            $this->getTemplatePath().'edit.html.twig',
            array(
                'form' => $form->createView(),
                'errors' => $form->getErrors()
            )
        );
    }

    /**
     * Delete instance action
     * 
     * @param string $id The instance ID
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($id)
    {
        $instance = $this->getManager()->find($id);
        if($instance) {
            $this->getManager()->delete($instance);
            $this->get('session')->setFlash('success', 'Instance Redis has been deleted successfully');
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
        return 'RingoPhpRedmonBundle:Crud:';
    }
    
    public function getForm($instance = null)
    {
        if($instance == null) {
            $instance = $this->getManager()->createNew();
        }
        
        return $this->createForm(
            $this->container->get('ringo_php_redmon.form.instance_type'),
            $instance
        );
    }
}