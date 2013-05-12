<?php

/*
 * This file is part of the phpRedmon project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ringo\Bundle\PhpRedmonBundle\Logger;

use Ringo\Bundle\PhpRedmonBundle\Model\Instance;
use Ringo\Bundle\PhpRedmonBundle\Manager\InstanceManager;
use Ringo\Bundle\PhpRedmonBundle\Worker\InstanceWorker;
use Ringo\Bundle\PhpRedmonBundle\Model\Log;

/**
 * Class InstanceLogger
 *
 * This class manage instance's logs 
 * 
 * @author Patrick Deroubaix <patrick.deroubaix@gmail.com>
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class InstanceLogger 
{
    /**
     * Current instance
     * 
     * @var \Ringo\Bundle\PhpRedmonBundle\Model\Instance
     */
    protected $instance;
    
    /**
     * Expired timestamp
     * 
     * @var int
     */
    protected $expiredTimestamp;
    
    /**
     * Current instance manager
     * 
     * @var \Ringo\Bundle\PhpRedmonBundle\Manager\InstanceManager
     */
    protected $manager;
    
    /**
     * Constructor
     * 
     * @param \Ringo\Bundle\PhpRedmonBundle\Manager\InstanceManager $manager
     * @param \Ringo\Bundle\PhpRedmonBundle\Worker\InstanceWorker $worker
     * @param int $nbDays
     */
    public function __construct(InstanceManager $manager, InstanceWorker $worker, $nbDays) 
    {
        $this->manager = $manager;
        $this->worker  = $worker;
        $this->expiredTimestamp  = $nbDays * 24 * 60 * 60;
    }
    
    /**
     * Get current instance
     * 
     * @return \Ringo\Bundle\PhpRedmonBundle\Model\Instance
     */
    public function getInstance()
    {
        return $this->instance;
    }
    
    /**
     * Set current instance
     * 
     * @param \Ringo\Bundle\PhpRedmonBundle\Model\Instance $instance
     * @return \Ringo\Bundle\PhpRedmonBundle\Logger\InstanceLogger
     */
    public function setInstance(Instance $instance)
    {
        $this->instance = $instance;
        
        return $this;
    }
    
    /**
     * Get instance manager
     * 
     * @return \Ringo\Bundle\PhpRedmonBundle\Manager\InstanceManager
     */
    public function getManager()
    {
        return $this->manager;
    }
    
    /**
     * Set instance manager
     * 
     * @param \Ringo\Bundle\PhpRedmonBundle\Manager\InstanceManager $manager
     * @return \Ringo\Bundle\PhpRedmonBundle\Logger\InstanceLogger
     */
    public function setManager(InstanceManager $manager)
    {
        $this->manager = $manager;
        
        return $this;
    }
    
    /**
     * Get instance worker
     * 
     * @return \Ringo\Bundle\PhpRedmonBundle\Worker\InstanceWorker
     */
    public function getWorker()
    {
        return $this->worker;
    }
    
    /**
     * Set instance worker
     * 
     * @param \Ringo\Bundle\PhpRedmonBundle\Worker\InstanceWorker $worker
     * @return \Ringo\Bundle\PhpRedmonBundle\Logger\InstanceLogger
     */
    public function setWorker(InstanceWorker $worker)
    {
        $this->worker = $worker;
        
        return $this;
    }
    
    /**
     * Clean instance history. Delete expired logs
     */
    protected function cleanHistory()
    {
        $createdAt = new \DateTime();
        $logs = $this->instance->getLogs();
        foreach($logs as $log) {
            if(($createdAt->getTimestamp() - $log->getCreatedAt()->getTimestamp()) > $this->expiredTimestamp) {
                $this->instance->removeLog($log);
            }
        }
    }
    
    /**
     * Create new log for the current instance
     */
    protected function log()
    {

        $this->worker
            ->setInstance($this->instance);
        // If instance can be called
        if($this->worker->ping()) {
            $infos = $this->worker->getInfos();
            $log = new Log();
            $log->setMemory($infos['Memory']['used_memory']);
            $log->setCpu($infos['CPU']['used_cpu_sys']);
            $log->setNbClients(sizeof($this->worker->getClients()));
            $log->setCreatedAt($createdAt);
            // Add log
            $this->instance->addLog($log);
        }
    }
    
    /**
     * Execute all steps for current instance
     * - Clean history
     * - Add log
     * - Save current instance state
     */
    public function execute()
    {
        $this->cleanHistory();
        $this->log();
        $this->manager->update($this->instance);
    }
}