<?php

namespace Itkg\Bundle\PhpRedmonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Itkg\Bundle\PhpRedmonBundle\Monitoring\RedisMonitoring;
use Itkg\Bundle\PhpRedmonBundle\Redis\Predis\Client;
use Itkg\Bundle\PhpRedmonBundle\Config\PhpRedmonConfig;

class PhpRedmonController extends Controller
{
    /**
     * @Route("/phpredmon",name="dashboard")
     * @Template()
     */
    public function indexAction()
    {
        
        $redis = new \Itkg\Bundle\PhpRedmonBundle\Redis\Predis\Client('tcp://192.168.50.4:6379');        
        //$redis = new \Itkg\Bundle\PhpRedmonBundle\Redis\Predis\Client('tcp://10.255.252.219:6379');        
        $monitoring =  new \Itkg\Bundle\PhpRedmonBundle\Monitoring\RedisMonitoring($redis);
        $infos = $monitoring->GetStat();
        
        
        $SlowLog = $monitoring->GetSlowLog();
        
  
        $keySpace = $monitoring->Getkeyspace();
   
        
     
        return array('Server'=>$infos['Server'],'Clients'=>$infos['Clients'],'Memory'=>$infos['Memory'],
             'Persistence' => $infos['Persistence'],'Stats'=>$infos['Stats'],'Replication'=>$infos['Replication'],
            'CPU'=>$infos['CPU'],'keyspace'=>$keySpace,'slowLog'=>$SlowLog);
    }
    /**
     * @Route("/phpredmon/client",name="client")
     * @Template()
     */
    public function clientAction()
    {
         $redis = new \Itkg\Bundle\PhpRedmonBundle\Redis\Predis\Client('tcp://192.168.50.4:6379');        
         $monitoring =  new \Itkg\Bundle\PhpRedmonBundle\Monitoring\RedisMonitoring($redis);
         $clientList =  $monitoring->GetClientList();
         return array('client_list'=>$clientList);
         
    }
    
    
    /**
     * @Route("/phpredmon/config",name="configuration")
     * @Template()
     */
    public function configAction()
    {
         $redis = new \Itkg\Bundle\PhpRedmonBundle\Redis\Predis\Client('tcp://192.168.50.4:6379');        
         $monitoring =  new \Itkg\Bundle\PhpRedmonBundle\Monitoring\RedisMonitoring($redis);
         $configlist =  $monitoring->GetConfig();
         return array('configlist'=>$configlist);
         
    }
    /**
     * @Route("/phpredmon/admin",name="administration")
     * @Template()
     */
    public function adminAction()
    {
        $config = new \Itkg\Bundle\PhpRedmonBundle\Config\PhpRedmonConfig();
        var_dump($config->GetValue());
        return array(' ');
    }
    
}