<?php

namespace Itkg\PhpRedmonBundle\Logger;

use Itkg\PhpRedmonBundle\Model\Instance;
use Itkg\PhpRedmonBundle\Manager\InstanceManager;
use Itkg\PhpRedmonBundle\Worker\InstanceWorker;
use Itkg\PhpRedmonBundle\Model\Log;

/**
 * Classe InstanceLogger
 *
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