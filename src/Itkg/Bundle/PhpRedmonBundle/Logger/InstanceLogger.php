<?php

/*
 * This file is part of the phpRedmon project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itkg\Bundle\PhpRedmonBundle\Logger;

use Itkg\Bundle\PhpRedmonBundle\Model\Instance;
use Itkg\Bundle\PhpRedmonBundle\Manager\InstanceManager;
use Itkg\Bundle\PhpRedmonBundle\Worker\InstanceWorker;
use Itkg\Bundle\PhpRedmonBundle\Model\Log;

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
     * @var \Itkg\Bundle\PhpRedmonBundle\Model\Instance
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
     * @var \Itkg\Bundle\PhpRedmonBundle\Manager\InstanceManager
     */
    protected $manager;
    
    /**
     * Constructor
     * 
     * @param \Itkg\Bundle\PhpRedmonBundle\Manager\InstanceManager $manager
     * @param \Itkg\Bundle\PhpRedmonBundle\Worker\InstanceWorker $worker
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
     * @return \Itkg\Bundle\PhpRedmonBundle\Model\Instance
     */
    public function getInstance()
    {
        return $this->instance;
    }
    
    /**
     * Set current instance
     * 
     * @param \Itkg\Bundle\PhpRedmonBundle\Model\Instance $instance
     * @return \Itkg\Bundle\PhpRedmonBundle\Logger\InstanceLogger
     */
    public function setInstance(Instance $instance)
    {
        $this->instance = $instance;
        
        return $this;
    }
    
    /**
     * Get instance manager
     * 
     * @return \Itkg\Bundle\PhpRedmonBundle\Manager\InstanceManager
     */
    public function getManager()
    {
        return $this->manager;
    }
    
    /**
     * Set instance manager
     * 
     * @param \Itkg\Bundle\PhpRedmonBundle\Manager\InstanceManager $manager
     * @return \Itkg\Bundle\PhpRedmonBundle\Logger\InstanceLogger
     */
    public function setManager(InstanceManager $manager)
    {
        $this->manager = $manager;
        
        return $this;
    }
    
    /**
     * Get instance worker
     * 
     * @return \Itkg\Bundle\PhpRedmonBundle\Worker\InstanceWorker
     */
    public function getWorker()
    {
        return $this->worker;
    }
    
    /**
     * Set instance worker
     * 
     * @param \Itkg\Bundle\PhpRedmonBundle\Worker\InstanceWorker $worker
     * @return \Itkg\Bundle\PhpRedmonBundle\Logger\InstanceLogger
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
            $createdAt = new \DateTime();

            $log = new Log();
            $log->setCreatedAt($createdAt);
            // Log infos
            $log->setDatas($infos);
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