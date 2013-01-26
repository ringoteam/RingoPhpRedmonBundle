<?php

namespace Itkg\PhpRedmonBundle\Manager;

use Itkg\PhpRedmonBundle\Model\Instance;

/**
 * Classe InstanceManager
 *
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