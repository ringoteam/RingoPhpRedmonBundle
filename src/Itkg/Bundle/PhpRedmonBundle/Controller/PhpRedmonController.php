<?php

namespace Itkg\Bundle\PhpRedmonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Itkg\Bundle\PhpRedmonBundle\Monitoring\RedisMonitoring;
use Itkg\Bundle\PhpRedmonBundle\Redis\Predis\Client;

class PhpRedmonController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction($name)
    {
        
        $redis = new \Itkg\Bundle\PhpRedmonBundle\Redis\Predis\Client('tcp://192.168.50.4:6379');
        $redis->set('foo', 'bar');
        $value = $redis->get('foo');
        
        $monitoring =  new \Itkg\Bundle\PhpRedmonBundle\Monitoring\RedisMonitoring($redis);
        $infos = $monitoring->GetStat();
        
        
        $ret = $monitoring->Showlog();
        $client_list = $monitoring->ClientList();
  
     
        $monitoring->GetInfoClient();
     
        return array('Server'=>$infos['Server'],'Clients'=>$infos['Clients'],'Memory'=>$infos['Memory'],
             'Persistence' => $infos['Persistence'],'Stats'=>$infos['Stats'],'Replication'=>$infos['Replication'],
            'CPU'=>$infos['CPU'],'client_list' => $client_list);
    }
}