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
        $monitoring->GetStat();
        return array('name' => $name);
    }
}