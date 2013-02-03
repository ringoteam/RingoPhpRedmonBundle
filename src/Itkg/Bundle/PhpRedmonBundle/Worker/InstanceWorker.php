<?php

/*
 * This file is part of the phpRedmon project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itkg\Bundle\PhpRedmonBundle\Worker;

use Itkg\Bundle\PhpRedmonBundle\Model\Instance;
use Itkg\Bundle\PhpRedmonBundle\Redis\Predis\Client;

/**
 * Classe InstanceWorker
 *
 * @author Patrick Deroubaix <patrick.deroubaix@gmail.com>
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class InstanceWorker 
{
    protected $instance;
    protected $client;
    protected $exception;
    
    public function __construct()
    {
        
    }
    
    public function ping()
    {
        return $response = $this->execute('ping');
    }
    
    public function flushDB($db)
    {
        $this->execute('select', array($db));
        $this->execute('flushDB');
    }
    
    public function getInfos()
    {
        return $this->execute('info');
    }
    
    public function getSlowLogs()
    {
        return $this->execute('slowlog', array('get', '20'));
    }
    
    public function getKeyspace()
    {
        return $this->execute('info', array('keyspace'));
    }
    
    public function getClients()
    {
        return $this->execute('client', array('list'));
    }

    public function getConfiguration()
    {
        return $this->execute('config', array('get','*'));
    }
    
    public function getException()
    {
        return $this->exception;
    }
    
    public function getMessage()
    {
        if($this->exception) {
            return $this->exception->getMessage();
        }
        return '';
    }
    
    public function getInstance()
    {
        return $this->instance;
    }
    
    public function setInstance(Instance $instance)
    {
        $this->instance = $instance;
        $this->exception = null;
        $this->connect();
        
        return $this;
    }
    
    protected function connect()
    {
        $this->client = new Client(array(
            'host'   => $this->instance->getHost(),
            'port'   => $this->instance->getPort(),
        ));
    }
    
    public function execute($method, $parameters = array())
    {
        try {
            $cmd = $this->client->createCommand($method, $parameters);
            return $this->client->executeCommand($cmd);
        }catch(\Exception $e) {
            $this->exception = $e;
            return false;
        }
    }
}