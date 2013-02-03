<?php

/*
 * This file is part of the phpRedmon project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itkg\Bundle\PhpRedmonBundle\Manager;

use Itkg\Bundle\PhpRedmonBundle\Model\Instance;

/**
 * Classe InstanceManager
 *
 * @author Patrick Deroubaix <patrick.deroubaix@gmail.com>
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class InstanceManager 
{
    protected $em;
    protected $class;
    
    public function __construct($entityManager, $class)
    {
        $this->em = $entityManager;
        $this->class = $class;
        $this->em->setClass($class);
    }
    
    public function create(Instance $instance)
    {
        $this->em->persist($instance);
    }
    
    public function update(Instance $instance)
    {
        $this->em->persist($instance);
    }
    
    public function find($id)
    {
        return $this->em->find($id);
    }
    
    public function findAll()
    {
        return $this->em->findAll();
    }
    
    public function createNew()
    {
        $class = $this->class;
        
        return new $class;
    }
}