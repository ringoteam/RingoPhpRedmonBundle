<?php

/*
 * This file is part of the phpRedmon project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itkg\Bundle\PhpRedmonBundle\Serializer;

/**
 * Classe EntitySerializer
 *
 * @author Patrick Deroubaix <patrick.deroubaix@gmail.com>
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class EntitySerializer 
{
    protected $fileManager;
    protected $class;
    protected $hash;
    
    public function __construct($fileManager)
    {
        $this->fileManager = $fileManager;
    }
    
    public function find($id)
    {
        $key = $this->getHash().$id;
        if($this->getFileManager()->has($key)) {
            return $this->_loadEntity($key);
        }
        
        return null;
    }
    
    public function persist($object)
    {
        if(!$object->getId()) {
            $object->setId($this->_getNextId());
        }
        $key = $this->getHash().$object->getId();
        $content = serialize($object);
        
        $this->getFileManager()->write($key, $content, true);
    }
    
    protected function _getNextId()
    {
        $keys = $this->getFileManager()->keys();
        $ids = array();
        foreach($keys as $key) {
            if(preg_match('/^'.$this->getHash().'/', $key)) {
                $ids[] = str_replace($this->getHash(), '', $key);
            }
        }
        if(empty($ids)) {
            return 1;
        }
        
        $maxId = max($ids);
        
        return $maxId + 1;
    }
    
    public function findAll()
    {
        $keys = $this->getFileManager()->keys();
        $entities = array();
        if(is_array($keys)) {
            foreach($keys as $key) {
                if(preg_match('/^'.$this->getHash().'/', $key)) {
                    $entities[] = $this->_loadEntity($key);
                }
            }
        }
        
        return $entities;
    }
    
    public function remove($object)
    {
        $key = $this->getHash().$object->getId();
        if($this->getFileManager()->has($key)) {
            $this->getFileManager()->delete($key);
        }
    }
    
    public function getFileManager()
    {
        return $this->fileManager;
    }
    
    public function setFileManager($fileManager)
    {
        $this->fileManager = $fileManager;
    }
    
    public function getClass()
    {
        return $this->class;
    }
    
    public function setClass($class)
    {
        $this->class = $class;
        $this->setHash(md5($class));                                                                                                                                                                                         
    }
    
    public function getHash()
    {
        return $this->hash;
    }
    
    public function setHash($hash)
    {
        $this->hash = $hash;
    }
    
    protected function _loadEntity($key)
    {
        $content = $this->getFileManager()->read($key);
        
        return unserialize($content);
    }
}