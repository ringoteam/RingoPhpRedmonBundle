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
       var_dump($cmdSetReply);
        
    }
    
}
