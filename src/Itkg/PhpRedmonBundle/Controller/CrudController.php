<?php

namespace Itkg\PhpRedmonBundle\Controller;

use Itkg\PhpRedmonBundle\Form\InstanceType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Classe CrudController
 *
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class CrudController extends Controller
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
                'form' => $this->getForm()->createView()
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
                $this->get('session')->setFlash('notice', 'Instance Redis ajouté avec succès');

                return new RedirectResponse($this->generateUrl('itkg_phpredmon_instances'));
            }else {
                $this->get('session')->setFlash('error', 'Des erreurs ont été trouvées');

            }
        }
        
        return $this->render(
            $this->getTemplatePath().'new.html.twig',
            array(
                'form' => $this->getForm()->createView()
            )
        );
    }
    
    public function editAction($id)
    {
        
        return $this->render(
            $this->getTemplatePath().'edit.html.twig',
            array(
                'form' => $this->getForm($this->getManager()->find($id))->createView(),
                'id'   => $id
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
                $this->get('session')->setFlash('notice', 'Instance Redis modifié avec succès');

                return new RedirectResponse($this->generateUrl('itkg_phpredmon_instances'));
            }else {
                $this->get('session')->setFlash('error', 'Des erreurs ont été trouvées');

            }
        }
        
        return $this->render(
            $this->getTemplatePath().'edit.html.twig',
            array(
                'form' => $this->getForm()->createView()
            )
        );
        
    }
    
    public function deleteAction($id)
    {
        return $this->render(
            $this->getTemplatePath().'index.html.twig',
            array()
        );
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
    
    public function getManager()
    {
        return $this->get('itkg_phpredmon.instance_manager');
    }
}