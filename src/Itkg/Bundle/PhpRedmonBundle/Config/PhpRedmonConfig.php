<?php

use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Parser;



namespace Itkg\Bundle\PhpRedmonBundle\Config;
/** 
 * PhpRedmonConfig
 * 
 */
class PhpRedmonConfig 
{
        private $value;
        
        public function __construct()
        {
            $yaml = new \Symfony\Component\Yaml\Parser();
            
            try {
                $this->value = $yaml->parse(file_get_contents(__DIR__.'/../Resources/config/phpredmon.yml'));
            } catch (ParseException $e) {
                printf("Unable to parse the YAML string: %s", $e->getMessage());
            }
        }
        
        public function GetValue()
        {
            return $this->value;
            
        }

}