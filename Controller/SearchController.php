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
 * Class SearchController
 *
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class SearchController extends BaseController
{
    /**
     * Search index action
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $results = array();
        $key  = '';
        $db   = '-1';
        if($this->getRequest()->isMethod('POST')) {
            $key = $this->getRequest()->get('key');
            $db  = $this->getRequest()->get('database');

            $keys = $this->getWorker()->keys($key, $db);

            if(empty($keys)) {
                $this->get('session')->getFlashBag()->add('notice', 'No result found');
            }else if(is_array($keys)) {
                foreach($keys as $k) {
                    $value = $this->getWorker()->get($k, $db);
                    $ttl = $this->getWorker()->ttl($k, $db);
                    $results[] = array(
                        'key'      => $k,
                        'value'    => $value,
                        'expireAt' => ($ttl == -1) ? '-' : strftime("%a %d %b %H:%M:%S %Y", time() + $ttl),
                        'weight'   => (mb_strlen($value, '8bit') / 1000). ' Kb'
                    );
                }
            }
        }

        return $this->render(
            $this->getTemplatePath().'index.html.twig',
            array(
                'instance'  => $this->getCurrentInstance(),
                'results'   => $results,
                'key'       => $key,
                'db'        => $db
            )
        );
    }

    public function removeAction()
    {
        $keys = $this->getRequest()->get('keys');
        $db  = $this->getRequest()->get('database');

        if(is_array($keys) && !empty($keys)) {
            try {
                $this->getWorker()->delete($keys, $db);
                $this->get('session')->getFlashBag()->add('success', 'Keys was deleted successfully');
            }catch(\Exception $e) {
                $this->get('session')->getFlashBag()->add('error', $e->getMessage());
            }
        }

        return $this->redirect('/search');
    }


    /**
     * Get template path for this controller
     *
     * @return string
     */
    protected function getTemplatePath()
    {
        return 'RingoPhpRedmonBundle:Search:';
    }
}