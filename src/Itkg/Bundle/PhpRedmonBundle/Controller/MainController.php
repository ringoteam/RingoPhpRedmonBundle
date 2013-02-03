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
 * Classe MainController
 *
 * @author Patrick Deroubaix <patrick.deroubaix@gmail.com>
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class MainController extends BaseController
{
    public function navigationAction()
    {
        return $this->render(
            $this->getTemplatePath().'navigation.html.twig',
            array(
                'instance'  => $this->getCurrentInstance(),
                'instances' => $this->getManager()->findAll()
            )
        );
    }
    
    public function infosAction()
    {
        return $this->render(
            $this->getTemplatePath().'infos.html.twig',
            array(
                'infos'  => $this->getWorker()->getInfos()
            )
        );
    }
    
    public function administrationAction()
    {
        return $this->render(
            $this->getTemplatePath().'administration.html.twig',
            array(
                'instance' => $this->getCurrentInstance(),
            )
        );
    }
    
    
    protected function getTemplatePath()
    {
        return 'ItkgPhpRedmonBundle:Main:';
    }
}