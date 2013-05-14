<?php

/*
 * This file is part of the phpRedmon project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ringo\Bundle\PhpRedmonBundle\Model;

/**
 * Class Info
 *
 * Represents specific array
 * 
 * @author Patrick Deroubaix <patrick.deroubaix@gmail.com>
 * @author Pascal DENIS <pascal.denis.75@gmail.com>
 */
class Info implements \ArrayAccess, \Iterator
{
    protected $container;
    protected $index;

    public function __construct(array $datas)
    {
        $this->container = $datas;
    }

    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }
    public function offsetExists($offset) {
        return isset($this->container[$offset]);
    }
    public function offsetUnset($offset) {
        unset($this->container[$offset]);
    }
    public function offsetGet($offset) {
        return isset($this->container[$offset]) ? $this->container[$offset] : '?';
    }

    public function rewind()
    {
        $this->index = 0;
    }
    public function current()
    {
        $k = array_keys($this->container);

        return $this->container[$k[$this->index]] ? $this->container[$k[$this->index]] : '?';
    }

    public function key()
    {
        $k = array_keys($this->container);

        return $k[$this->index];
    }

    public function next()
    {
        $k = array_keys($this->container);
        if (isset($k[++$this->index])) {
            $var = $this->container[$k[$this->index]];
            return $var;
        } else {
            return false;
        }
    }

    public function valid()
    {
        $k = array_keys($this->container);
        
        return isset($k[$this->index]);
    }
}