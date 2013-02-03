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
 * Class InstanceManager
 *
 * This class manage Redis instances 
 * 
 * @author Patrick Deroubaix <patrick.deroubaix@gmail.com>
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class InstanceManager 
{
    /**
     * Entity manager
     * 
     * @var mixed
     */
    protected $em;
    
    /**
     * Instance class
     * 
     * @var string
     */
    protected $class;
    
    /**
     * Constructor
     * 
     * @param mixed $entityManager
     * @param string $class
     */
    public function __construct($entityManager, $class)
    {
        $this->em = $entityManager;
        $this->class = $class;
        $this->em->setClass($class);
    }
    
    /**
     * Create a new instance
     * 
     * @param \Itkg\Bundle\PhpRedmonBundle\Model\Instance $instance
     */
    public function create(Instance $instance)
    {
        $this->em->persist($instance);
    }
    
    /**
     * Update an existing instance
     * 
     * @param \Itkg\Bundle\PhpRedmonBundle\Model\Instance $instance
     */
    public function update(Instance $instance)
    {
        $this->em->persist($instance);
    }
    
    /**
     * Remove an existing instance
     * 
     * @param \Itkg\Bundle\PhpRedmonBundle\Model\Instance $instance
     */
    public function delete(Instance $instance)
    {
        $this->instance->remove($instance);
    }
    
    /**
     * Find an instance by ID
     * 
     * @param string $id
     * @return \Itkg\Bundle\PhpRedmonBundle\Model\Instance 
     */
    public function find($id)
    {
        return $this->em->find($id);
    }
    
    /**
     * Find all instances
     * 
     * @return array
     */
    public function findAll()
    {
        return $this->em->findAll();
    }
    
    /**
     * Create an empty Redis instance
     * 
     * @return \Itkg\Bundle\PhpRedmonBundle\Model\Instance
     */
    public function createNew()
    {
        $class = $this->class;
        
        return new $class;
    }
}