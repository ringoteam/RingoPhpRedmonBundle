<?php

/*
 * This file is part of the phpRedmon project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ringo\Bundle\PhpRedmonBundle\Model;

/**
 * Class Log
 *
 * Represents a simple log for Redis instance
 * 
 * @author Patrick Deroubaix <patrick.deroubaix@gmail.com>
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class Log 
{
    /**
     * ID
     * 
     * @var string 
     */
    protected $id;
    
    /**
     * Created date
     * 
     * @var \DateTime
     */
    protected $createdAt;
    
    /**
     * Memory usage
     * 
     * @var string 
     */
    protected $memory;

    /**
     * CPU usage
     * 
     * @var string
     */
    protected $cpu;

    /**
     * nbClients connected
     * 
     * @var int
     */
    protected $nbClients;
    
    /**
     * Instance
     * 
     * @var Snide\Redmon\Model\Instance
     */
    protected $instance;

    /**
     * Get ID
     * 
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set ID
     * 
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * Get created date
     * 
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set created date
     * 
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }
    
    /**
     * Get memory usage
     * 
     * @return string Amount of memory used
     */
    public function getMemory()
    {
        return $this->memory;
    }

    /**
     * Set memory usage
     * 
     * @param string $memory Amount of memory used
     */
    public function setMemory($memory)
    {
        $this->memory = $memory;
    }

    /**
     * Get cpu usage
     * 
     * @return string Amount of cpu used
     */
    public function getCpu()
    {
        return $this->cpu;
    }

    /**
     * Set cpu usage
     * 
     * @param string $cpu Amount of cpu used
     */
    public function setCpu($cpu)
    {
        $this->cpu = $cpu;
    }

    /**
     * Get nbClients
     * 
     * @return int nb clients connected
     */
    public function getNbClients()
    {
        return $this->nbClients;
    }

    /**
     * Set nbClients
     * 
     * @param int $nbClients nb clients connected
     */
    public function setNbClients($nbClients)
    {
        $this->nbClients = $nbClients;
    }
    
    /**
     * Get instance
     * 
     * @return Instance 
     */
    public function getInstance()
    {
        return $this->instance;
    }

    /**
     * Set instance
     * 
     * @param Instance $instance 
     */
    public function setInstance(Instance $instance)
    {
        $this->instance = $instance;
    }
}