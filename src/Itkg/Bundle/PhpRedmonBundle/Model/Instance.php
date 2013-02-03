<?php

/*
 * This file is part of the phpRedmon project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itkg\Bundle\PhpRedmonBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
/**
 * Class Instance
 *
 * Represents a Redis instance
 * 
 * @author Patrick Deroubaix <patrick.deroubaix@gmail.com>
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class Instance 
{
    /**
     * ID
     * 
     * @var string
     */
    protected $id;
    
    /**
     * Name
     * 
     * @var string 
     */
    protected $name;
    
    /**
     * Port
     * 
     * @var string 
     */
    protected $port;
    
    /**
     * Host
     * 
     * @var string 
     */
    protected $host;
    
    /**
     * Databases
     * 
     * @var \Doctrine\Common\Collections\ArrayCollection  
     */
    protected $databases;
    
    /**
     * Logs
     * 
     * @var \Doctrine\Common\Collections\ArrayCollection  
     */
    protected $logs;
    
    /**
     * State 
     * 
     * @var boolean 
     */
    protected $working;
    
    /**
     * Potential error message
     * 
     * @var string 
     */
    protected $error;
    
    /**
     * Add a database
     * 
     * @param \Itkg\Bundle\PhpRedmonBundle\Model\Database $database
     */
    public function addDatabase(Database $database)
    {
        $database->setId($this->getDatabases()->count());
        $this->getDatabases()->add($database);
    }
    
    /**
     * Remove a database
     * 
     * @param \Itkg\Bundle\PhpRedmonBundle\Model\Database $database
     */
    public function removeDatabase(Database $database) 
    {
        $this->getDatabases()->remove($database);
    }
    
    /**
     * Add a log
     * 
     * @param \Itkg\Bundle\PhpRedmonBundle\Model\Log $log
     */
    public function addLog(Log $log)
    {
        $this->getLogs()->add($log);
    }
    
    /**
     * Remove a log
     * 
     * @param \Itkg\Bundle\PhpRedmonBundle\Model\Log $log
     */
    public function removeLog(Log $log)
    {
        $this->getLogs()->remove($log);
    }
    
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
     * Get name
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Get host
     * 
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }
    
    /**
     * Get port
     * 
     * @return string
     */
    public function getPort()
    {
        return $this->port;
    }
    
    /**
     * Get databases
     * 
     * @return \Doctrine\Common\Collections\ArrayCollection  
     */
    public function getDatabases()
    {
        if($this->databases == null) {
            $this->databases = new ArrayCollection();
        }
        return $this->databases;
    }

    /**
     * Get a database by ID
     * 
     * @param int $id
     * @return null|\Itkg\Bundle\PhpRedmonBundle\Model\Database
     */
    public function getDatabase($id)
    {
        foreach($this->getDatabases() as $database) {
            if($database->getId() == $id) {
                return $database;
            }
        }
        
        return null;
    }
    
    /**
     * Get potential error message
     * 
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }
    
    /**
     * Get logs
     * 
     * @return \Doctrine\Common\Collections\ArrayCollection  
     */
    public function getLogs()
    {
        if($this->logs == null) {
            $this->logs = new ArrayCollection();
        }
        
        return $this->logs;
    }
    
    /**
     * Get state
     * 
     * @return boolean
     */
    public function isWorking()
    {
        return $this->working;
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
     * Set name
     * 
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * Set host
     * 
     * @param string $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }
    
    /**
     * Set port
     * 
     * @param string $port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }
    
    /**
     * Set databases
     * 
     * @param \Doctrine\Common\Collections\ArrayCollection $databases
     */
    public function setDatabases(ArrayCollection $databases)
    {
        $this->databases = $databases;
    }
 
    /**
     * Set error message
     * 
     * @param string $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }
    
    /**
     * Set logs
     * 
     * @param \Doctrine\Common\Collections\ArrayCollection $logs
     */
    public function setLogs(ArrayCollection $logs)
    {
        $this->logs = $logs;
    }
    
    /**
     * Set state
     * 
     * @param boolean $working
     */
    public function setWorking($working) 
    {
        $this->working = $working;
    }
}