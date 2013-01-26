<?php

namespace Itkg\PhpRedmonBundle\Controller;

use Itkg\PhpRedmonBundle\Form\InstanceType;
use Itkg\PhpRedmonBundle\Model\Instance;
use Itkg\PhpRedmonBundle\Manager\InstanceManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Classe CrudController
 *
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class CrudController extends Controller
{
    
    public function indexAction()
    {
        return $this->render(
            $this->getTemplatePath().'index.html.twig',
            array()
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
        
    }
    
    public function editAction($id)
    {
        
        return $this->render(
            $this->getTemplatePath().'edit.html.twig',
            array(
                'form' => $this->getForm($this->getManager()->find($id))->createView()
            )
        );
    }
    
    public function updateAction($id)
    {
        return $this->render(
            $this->getTemplatePath().'index.html.twig',
            array()
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