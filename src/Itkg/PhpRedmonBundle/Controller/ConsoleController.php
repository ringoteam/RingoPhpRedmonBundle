<?php

namespace Itkg\PhpRedmonBundle\Controller;

use Itkg\PhpRedmonBundle\Form\InstanceType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Itkg\PhpRedmonBundle\Controller\Controller as BaseController;

/**
 * Classe ConsoleController
 *
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class ConsoleController extends BaseController
{
    public function indexAction()
    {
        
    }
    
    protected function getTemplatePath()
    {
        return 'ItkgPhpRedmonBundle:Admin:';
    }
}