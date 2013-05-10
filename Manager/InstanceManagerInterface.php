<?php

/*
 * This file is part of the phpRedmon project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ringo\Bundle\PhpRedmonBundle\Manager;

use Ringo\Bundle\PhpRedmonBundle\Model\Instance;

/**
 * Interface InstanceManagerInterface
 *
 * This interface provide methods to manage Redis instances 
 * 
 * @author Patrick Deroubaix <patrick.deroubaix@gmail.com>
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
interface InstanceManagerInterface
{
    /**
     * Create a new instance
     * 
     * @param \Ringo\Bundle\PhpRedmonBundle\Model\Instance $instance
     */
    public function create(Instance $instance);
    
    /**
     * Update an existing instance
     * 
     * @param \Ringo\Bundle\PhpRedmonBundle\Model\Instance $instance
     */
    public function update(Instance $instance);
    
    /**
     * Remove an existing instance
     * 
     * @param \Ringo\Bundle\PhpRedmonBundle\Model\Instance $instance
     */
    public function delete(Instance $instance);
    
    /**
     * Find an instance by ID
     * 
     * @param string $id
     * @return \Ringo\Bundle\PhpRedmonBundle\Model\Instance 
     */
    public function find($id);
    
    /**
     * Find all instances
     * 
     * @return array
     */
    public function findAll();
    
    /**
     * Create an empty Redis instance
     * 
     * @return \Ringo\Bundle\PhpRedmonBundle\Model\Instance
     */
    public function createNew();
}