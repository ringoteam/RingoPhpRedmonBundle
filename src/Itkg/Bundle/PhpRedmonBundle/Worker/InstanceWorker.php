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
 * Class InstanceWorker
 *
 * A worker to call Redis commands through redis instance
 * 
 * @author Patrick Deroubaix <patrick.deroubaix@gmail.com>
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class InstanceWorker 
{
    /**
     * Redis instance
     * 
     * @var \Itkg\Bundle\PhpRedmonBundle\Model\Instance
     */
    protected $instance;
    
    /**
     * Redis client
     * 
     * @var \Itkg\Bundle\PhpRedmonBundle\Redis\Predis\Client
     */
    protected $client;
    
    /**
     * Potential exception
     * 
     * @var \Exception
     */
    protected $exception;
    
    /**
     * Constructor
     */
    public function __construct()
    {}
    
    /**
     * Ping the server
     * 
     * @return boolean
     */
    public function ping()
    {
        return $response = $this->execute('ping');
    }
    
    /**
     * Flush an instance Database
     * @param int $db Database index
     */
    public function flushDB($db)
    {
        $this->execute('select', array($db));
        $this->execute('flushDB');
    }
    
    /**
     * Get infos from server
     * 
     * @return array
     */
    public function getInfos()
    {
        return $this->execute('info');
    }
    
    /**
     * Get slow logs
     * 
     * @return array
     */
    public function getSlowLogs()
    {
        return $this->execute(
            'slowlog', 
            array(
                'get',
                '20'
            )
        );
    }
    
    /**
     * Get keyspace
     *  
     * @return array
     */
    public function getKeyspace()
    {
        return $this->execute('info', array('keyspace'));
    }
    
    /**
     * Get clients list
     * 
     * @return array
     */
    public function getClients()
    {
        return $this->execute('client', array('list'));
    }

    /**
     * Get config
     * 
     * @return array
     */
    public function getConfiguration()
    {
        return $this->execute('config', array('get','*'));
    }
    
    /**
     * Get exception
     * 
     * @return \Exception|null
     */
    public function getException()
    {
        return $this->exception;
    }
    
    /**
     * Get error message
     * 
     * @return string
     */
    public function getMessage()
    {
        if($this->exception) {
            return $this->exception->getMessage();
        }
        return '';
    }
    
    /**
     * Get current instance
     * 
     * @return Itkg\Bundle\PhpRedmonBundle\Model\Instance|null
     */
    public function getInstance()
    {
        return $this->instance;
    }
    
    /**
     * Set current instance
     * 
     * @param \Itkg\Bundle\PhpRedmonBundle\Model\Instance $instance
     * @return \Itkg\Bundle\PhpRedmonBundle\Worker\InstanceWorker
     */
    public function setInstance(Instance $instance)
    {
        $this->instance = $instance;
        $this->exception = null;
        $this->connect();
        
        return $this;
    }
    
    /**
     * Connect redis client to the server
     */
    protected function connect()
    {
        $this->client = new Client(array(
            'host'   => $this->instance->getHost(),
            'port'   => $this->instance->getPort(),
        ));
    }
    
    /**
     * Execute commands
     * 
     * @param string $command
     * @param array $parameters
     * 
     * @return mixed
     */
    public function execute($command, $parameters = array())
    {
        try {
            $cmdSet = $this->client->createCommand($command, $parameters);
            return $this->client->executeCommand($cmdSet);
        }catch(\Exception $e) {
            $this->exception = $e;
            return false;
        }
    }
}