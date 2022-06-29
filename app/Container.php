<?php

namespace App;

use ArrayAccess;
use ReturnTypeWillChange;

class Container implements ArrayAccess
{
    protected $items = [];
    protected $cache = [];

    public function __construct(array $items = [])
    {
        foreach ($items as $key => $item) {
            $this->offsetSet($key, $item);
        }
    }

    public function offsetExists($offset) : bool
    {
        return isset($this->items[$offset]);
    }

    #[ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        if(!$this->offsetExists($offset)) {
            return null;
        }
        $item = $this->items[$offset]($this);
        if(isset($this->cache[$offset])) {
            return $this->cache[$offset];
        }
        $this->cache[$offset] = $item;
        return $item;
    }

    #[ReturnTypeWillChange]
    public function offsetSet($offset, $value)
    {
        $this->items[$offset] = $value;
    }

    #[ReturnTypeWillChange]
    public function offsetUnset($offset)
    {
        if($this->offsetExists($offset)) {
            unset($this->items[$offset]);
        }
    }
    public function __get($name)
    {
        return $this->offsetGet($name);
    }
}
