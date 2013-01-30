<?php

namespace Itkg\PhpRedmonBundle\Model;

/**
 * Classe Log
 *
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class Log 
{
    protected $id;
    protected $createdAt;
    protected $datas;
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
        $this->id = $createdAt->getTimestamp();
    }
    
    public function getDatas()
    {
        return $this->datas;
    }
    
    public function setDatas(array $datas = array())
    {
        $this->datas = $datas;
    }
}