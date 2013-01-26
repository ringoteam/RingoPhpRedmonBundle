<?php

namespace Itkg\PhpRedmonBundle\Serializer;

/**
 * Classe EntitySerializer
 *
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
        
    }
    
    public function persist($object)
    {
        
    }
    
    protected function getNextId()
    {
        
    }
    
    public function findAll()
    {
        
    }
    
    public function remove($object)
    {
        
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
    
}