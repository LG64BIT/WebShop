<?php

namespace shop;

use ArrayAccess;

class Container implements ArrayAccess
{
    protected $items = [];

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    public function offsetGet($offset)
    {
        if($this->offsetExists($offset))
            return $this->items[$offset];
        return null;
    }

    public function offsetSet($offset, $value)
    {
        $this->items[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        if($this->offsetExists($offset))
            unset($this->items[$offset]);
    }
}