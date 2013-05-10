<?php

/*
 * This file is part of the phpRedmon project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ringo\Bundle\PhpRedmonBundle\Serializer;

/**
 * Class EntitySerializer
 *
 * Save entity in serialize format into a file
 * 
 * @author Patrick Deroubaix <patrick.deroubaix@gmail.com>
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class EntitySerializer 
{
    /**
     * File manager
     * 
     * @var mixed 
     */
    protected $fileManager;
    
    /**
     * Object class
     * 
     * @var string 
     */
    protected $class;
    
    /**
     * Hash associated to the class
     * 
     * @var string
     */
    protected $hash;
    
    /**
     * Constructor
     * 
     * @param mixed $fileManager
     */
    public function __construct($fileManager)
    {
        $this->fileManager = $fileManager;
    }
    
    /**
     * Find an entity by ID
     * 
     * @param string $id
     * @return null|mixed
     */
    public function find($id)
    {
        $key = $this->getHash().$id;
        if($this->getFileManager()->has($key)) {
            return $this->loadEntity($key);
        }
        
        return null;
    }
    
    /**
     * Save an object entity
     * 
     * @param mixed $object
     */
    public function persist($object)
    {
        if(!$object->getId()) {
            $object->setId($this->getNextId());
        }
        $key = $this->getHash().$object->getId();
        $content = serialize($object);
        
        $this->getFileManager()->write($key, $content, true);
    }
    
    
    /**
     * Find all entities for a specific class
     * 
     * @return array
     */
    public function findAll()
    {
        $keys = $this->getFileManager()->keys();
        $entities = array();
        if(is_array($keys)) {
            foreach($keys as $key) {
                if(preg_match('/^'.$this->getHash().'/', $key)) {
                    $entities[] = $this->loadEntity($key);
                }
            }
        }
        
        return $entities;
    }
    
    /**
     * Remove an entity
     * 
     * @param mixed $object
     */
    public function remove($object)
    {
        $key = $this->getHash().$object->getId();
        if($this->getFileManager()->has($key)) {
            $this->getFileManager()->delete($key);
        }
    }
    
    /**
     * Get file manager
     * 
     * @return mixed
     */
    public function getFileManager()
    {
        return $this->fileManager;
    }
    
    /**
     * Set file manager
     * 
     * @param mixed $fileManager
     */
    public function setFileManager($fileManager)
    {
        $this->fileManager = $fileManager;
    }
    
    /**
     * Get current entity class
     * 
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }
    
    /**
     * Set current entity class
     * 
     * @param string $class
     */
    public function setClass($class)
    {
        $this->class = $class;
        $this->setHash(md5($class));                                                                                                                                                                                         
    }
    
    /**
     * Get hash
     * 
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }
    
    /**
     * Set hash
     * 
     * @param string $hash
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    }
    
    /**
     * Load an entity by key
     * 
     * @param string $key
     * @return mixed|null
     */
    protected function loadEntity($key)
    {
        $content = $this->getFileManager()->read($key);
        if($content) {
            return unserialize($content);
        }
        
        return null;
    }

    /**
     * Get next ID for an object class
     * 
     * @return int
     */
    protected function getNextId()
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
}