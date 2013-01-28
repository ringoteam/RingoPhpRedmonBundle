<?php

namespace Itkg\PhpRedmonBundle\Model;

/**
 * Classe Database
 *
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class Database 
{
    protected $id;
    
    protected $name;
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }
}