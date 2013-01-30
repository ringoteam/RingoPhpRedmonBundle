<?php

namespace Itkg\PhpRedmonBundle\Controller;

use Itkg\PhpRedmonBundle\Form\InstanceType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Itkg\PhpRedmonBundle\Controller\Controller as BaseController;

/**
 * Classe MainController
 *
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class MainController extends BaseController
{
    public function navAction()
    {
        return $this->render(
            $this->getTemplatePath().'nav.html.twig',
            array(
            'instance'  => $this->getCurrentInstance(),
            'instances' => $this->getManager()->findAll()
        ));
    }
    
    protected function getTemplatePath()
    {
        return 'ItkgPhpRedmonBundle:Main:';
    }
}