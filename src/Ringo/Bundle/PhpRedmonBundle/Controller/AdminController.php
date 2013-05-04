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
 * Class AdminController
 *
 * @author Patrick Deroubaix <patrick.deroubaix@gmail.com>
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class AdminController extends BaseController
{
    public function indexAction()
    {}
    
    /**
     * Call flush all command for the current instance
     * 
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function flushAllAction()
    {
        try {
            $this->getWorker()->execute('flushAll');
            
            $this->get('session')->setFlash('success', 'Flush ALL executed successfully');
        }catch(\Exception $e) {
            $this->get('session')->setFlash('success', 'We have encountered an error : '.$e->getMessage());
        }
        
        return new RedirectResponse($this->generateUrl('ringo_php_redmon'));
    }
    
    /**
     * Call flush DB command for the current instance and the current database
     * 
     * @param int $id Database index
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function flushDbAction($id)
    {
        try {
            $worker = $this->getWorker()->flushDB($id);
            
            $this->get('session')->setFlash('success', 'Flush DB on '.$worker->getInstance()->getDatabase($id)->getName().' executed successfully');
        }catch(\Exception $e) {
            $this->get('session')->setFlash('success', 'Une erreur s\'est produite : '.$e->getMessage());
        }
        
        return new RedirectResponse($this->generateUrl('ringo_php_redmon'));
    }
    
    /**
     * Get the template path for this controller
     * 
     * @return string
     */
    protected function getTemplatePath()
    {
        return 'RingoPhpRedmonBundle:Admin:';
    }
}