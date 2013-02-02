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
 * Classe InstanceLogger
 *
 * @author Patrick Deroubaix <patrick.deroubaix@gmail.com>
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class InstanceLogger 
{
    protected $instance;
    protected $expiredTimestamp;
    protected $manager;
    
    public function __construct(InstanceManager $manager, InstanceWorker $worker, $nbDays) 
    {
        $this->manager = $manager;
        $this->worker  = $worker;
        $this->expiredTimestamp  = $nbDays * 24 * 60 * 60;
    }
    
    public function getInstance()
    {
        return $this->instance;
    }
    
    public function setInstance(Instance $instance)
    {
        $this->instance = $instance;
        
        return $this;
    }
    
    public function getManager()
    {
        return $this->manager;
    }
    
    public function setManager(InstanceManager $manager)
    {
        $this->manager = $manager;
        
        return $this;
    }
    
    public function getWorker()
    {
        return $this->worker;
    }
    
    public function setWorker(InstanceWorker $worker)
    {
        $this->worker = $worker;
        
        return $this;
    }
    
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
    
    protected function log()
    {
        $infos = $this->worker
            ->setInstance($this->instance)
            ->getInfos();
        $createdAt = new \DateTime();
        
        $log = new Log();
        $log->setCreatedAt($createdAt);
        $log->setDatas($infos);
        
        $this->instance->addLog($log);
    }
    
    public function execute()
    {
        $this->cleanHistory();
        $this->log();
        $this->manager->update($this->instance);
    }
}