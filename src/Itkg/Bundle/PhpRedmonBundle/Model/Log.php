<?php

/*
 * This file is part of the phpRedmon project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itkg\Bundle\PhpRedmonBundle\Model;

/**
 * Class Log
 *
 * Represents a simple log for Redis instance
 * 
 * @author Patrick Deroubaix <patrick.deroubaix@gmail.com>
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class Log 
{
    /**
     * ID
     * 
     * @var string 
     */
    protected $id;
    
    /**
     * Created date
     * 
     * @var \DateTime
     */
    protected $createdAt;
    
    /**
     * Datas
     * 
     * @var array 
     */
    protected $datas;
    
    /**
     * Get ID
     * 
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set ID
     * 
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * Get created date
     * 
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
    /**
     * Set created date
     * 
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
        $this->id = $createdAt->getTimestamp();
    }
    
    /**
     * Get datas
     * 
     * @return array
     */
    public function getDatas()
    {
        return $this->datas;
    }
    
    /**
     * Set datas
     * 
     * @param array $datas
     */
    public function setDatas(array $datas = array())
    {
        $this->datas = $datas;
    }
}