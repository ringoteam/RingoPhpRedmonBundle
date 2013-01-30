<?php

namespace Itkg\PhpRedmonBundle\Worker;

use Itkg\PhpRedmonBundle\Model\Instance;

use Predis\Client;

/**
 * Classe InstanceWorker
 *
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class InstanceWorker 
{
    protected $instance;
    protected $client;
    
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
    
    public function getInstance()
    {
        return $this->instance;
    }
    
    public function setInstance(Instance $instance)
    {
        $this->instance = $instance;
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
            return $this->client->__call($method, $parameters);
        }catch(\Exception $e) {
            throw $e;
            return false;
        }
    }
}