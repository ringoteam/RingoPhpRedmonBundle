<?php
/*
 * This file is part of the phpRedmon .
 *
 * @author Patrick Deroubaix <patrick.deroubaix@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Itkg\Bundle\PhpRedmonBundle\Monitoring;
/** 
 * RedisMonitoring
 * 
 */
class RedisMonitoring
{
    
    protected $redis;

    /**
     * Constructor.
     *
     * @param redisclient $redis A redisClient instance
     * 
     */
    
    public function __construct($redis = null)
    {
        $this->redis = $redis;
    }
    
    /** 
     * GetStat
     * 
     * @return array redis 
     * 
     */
    
    public function GetStat() 
    {
      $cmdSet = $this->redis->createCommand('info');
      
      $cmdSetReply = $this->redis->executeCommand($cmdSet);
     
      
      return $cmdSetReply;
        
    }
    
   
    
    public function Getkeyspace()
    {
         $cmdSet = $this->redis->createCommand('info',array('keyspace'));
         $cmdSetReply = $this->redis->executeCommand($cmdSet);
         return $cmdSetReply;
        
    }
    
    /**
     * slowLog
     * 
     * @return array 
     * 
     */
    
    public function GetSlowLog()
    {
      $cmdSet = $this->redis->createCommand('slowlog',array('get', '20'));
      
      $cmdSetReply = $this->redis->executeCommand($cmdSet);
      
      return $cmdSetReply;
        
    }
    /**
     * ClientList
     * 
     * @return array 
     * 
     */
    public function GetClientList()
    {
        
      $cmdSet = $this->redis->createCommand('client',array('list'));
      $cmdSetReply = $this->redis->executeCommand($cmdSet);
      return $cmdSetReply;
 
    }
    
    
     /**
     * ClientList
     * 
     * @return array 
     * 
     */
    public function GetConfig()
    {
        
      $cmdSet = $this->redis->createCommand('config',array('get','*'));
      $cmdSetReply = $this->redis->executeCommand($cmdSet);
      return $cmdSetReply;
 
    }
   
    
}
