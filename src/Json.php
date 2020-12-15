<?php

namespace Geriano\Helpers;

use ArrayAccess;

class Json implements ArrayAccess
{
  /**
   * @var array $data 
   */
  protected array $__data = [];
  /**
   * @param array $data
   * @return void
   */
  public function __construct(array|string $data)
  {
    if(is_array($data)) $this->__data = $data;
    else $this->__data = json_decode($data, true);
  }

  /**
   * @param string
   */
  public function __get(string $key)
  {
    return Arr::get($this->data, $key);
  }

  /**
   * @return string
   */
  public function __toString() : string 
  {
    return json_encode($this->__data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
  }

  /**
   * @param string|int $offset
   */
  public function offsetExists($offset)
  {
    return array_key_exists($offset, $this->__data);
  }

  /**
   * @param string|int $offset
   */
  public function offsetGet($offset)
  {
    $offset = (string) $offset;

    return $this->{$offset};
  }

  /**
   * @param string|int $offset
   */
  public function offsetSet($offset, $val)
  {
    return $this->__data[$offset] = $val;
  }

  /**
   * @param string|int $offset
   */
  public function offsetUnset($offset)
  {
    unset($this->__data[$offset]);
  }
}