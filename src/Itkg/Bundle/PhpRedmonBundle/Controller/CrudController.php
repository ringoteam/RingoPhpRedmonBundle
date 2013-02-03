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
 * Classe CrudController
 *
 * @author Patrick Deroubaix <patrick.deroubaix@gmail.com>
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class CrudController extends BaseController
{
    
    public function indexAction()
    {
        $instances = $this->getManager()->findAll();
        return $this->render(
            $this->getTemplatePath().'index.html.twig',
            array(
                'instances' => $instances
            )
        );
    }

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

    public function createAction()
    {
        $form = $this->getForm();

        $request = $this->get('request');
        if ('POST' == $request->getMethod()) {
            $form->bindRequest($request);
            if ($form->isValid()) {
                
                $this->getManager()->create($form->getData());
                $this->get('session')->setFlash('success', 'Instance Redis created successfully');

                return new RedirectResponse($this->generateUrl('itkg_php_redmon'));
            }else {
                $this->get('session')->setFlash('error', 'Some errors found');

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
    
    public function editAction($id)
    {
        $instance = $this->getManager()->find($id);
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
    
    public function updateAction($id)
    {
        $form = $this->getForm();

        $request = $this->get('request');
        if ('POST' == $request->getMethod()) {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $this->getManager()->create($form->getData());
                $this->get('session')->setFlash('success', 'Instance Redis updated successfully');

                return new RedirectResponse($this->generateUrl('itkg_php_redmon'));
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
    
    public function deleteAction($id)
    {
        $instance = $this->getManager()->find($id);
        if($instance) {
            $this->getManager()->delete($instance);
            $this->get('session')->setFlash('success', 'Instance Redis has been deleted successfully');
        }else {
            $this->get('session')->setFlash('error', 'This instance does not exist');
        }
        
        return new RedirectResponse($this->generateUrl('itkg_php_redmon'));
    }
    
    protected function getTemplatePath()
    {
        return 'ItkgPhpRedmonBundle:Crud:';
    }
    
    public function getForm($instance = null)
    {
        if($instance == null) {
            $instance = $this->getManager()->createNew();
        }
        
        return $this->createForm(new InstanceType(), $instance);
    }
}