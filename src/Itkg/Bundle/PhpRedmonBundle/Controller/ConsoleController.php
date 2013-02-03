<?php

/*
 * This file is part of the phpRedmon project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itkg\Bundle\PhpRedmonBundle\Controller;

use Itkg\Bundle\PhpRedmonBundle\Controller\Controller as BaseController;

/**
 * Class ConsoleController
 *
 * @author Patrick Deroubaix <patrick.deroubaix@gmail.com>
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class ConsoleController extends BaseController
{
    public function indexAction()
    {}
    
    /**
     * Get template path for this controller
     * 
     * @return string
     */
    protected function getTemplatePath()
    {
        return 'ItkgPhpRedmonBundle:Console:';
    }
}