<?php

namespace Geriano\Helpers;

use ArrayIterator;

class Arr
{
  /**
   * Get value from array
   * 
   * @param array $data
   * @param string|int $key
   * @param mixed $default
   * @return mixed
   */
  public static function get(array $data, string|int $key, $default = null)
  {
    if(array_key_exists($key, $data)) return $data[$key];

    if(is_int($key)) return $default;

    if(strpos($key, '.') !== false) return Arr::dot($data, $key, $default);

    return $default;
  }

  /**
   * @param array $data
   * @param string $key
   * @param mixed $default
   * @return mixed
   */
  public static function dot(array $data, string $key, $default = null)
  {
    $keys  = explode('.', $key);
    $first = array_shift($keys);

    if(Arr::has($data, $first, false)) {
      if($keys) return Arr::get($data[$first], implode('.', $keys), $default);

      return $data[$first];
    }

    return $default;
  }

  /**
   * Wrap an item to array
   * 
   * @param mixed $item
   * @return array
   */
  public static function wrap($item) : array
  {
    if(is_array($item)) return $item;
    if(is_null($item)) return [];

    return [$item];
  }

  /**
   * Check an array key exists
   * 
   * @param array $data
   * @param string|int $key
   * @param bool $dot
   * @return bool
   */
  public static function has(array $data, string|int $key, bool $dot = true)
  {
    if(array_key_exists($key, $data)) return true;
    if(! is_string($key) or ! $dot) return false;

    $keys  = explode('.', $key);
    $first = array_shift($keys);

    if(Arr::has($data, $first, false)) {
      if($keys) return Arr::has($data[$first], implode('.', $keys), true);

      return true;
    }

    return false;
  }

  /**
   * Set value to array
   * 
   * @param array $data
   * @param string|int $key 
   * @param mixed $val
   * @param bool $dot
   * @return array
   */
  public static function set(array &$data, string|int $key, $val, bool $dot = true)
  {
    if(is_int($key) or ! $dot) {
      $data[$key] = $val;

      return $data;
    }

    $keys  = explode('.', $key);
    $first = array_shift($keys);

    if(Arr::has($data, $first, false)) {
      if($keys) return $data[$first] = Arr::set($data[$first], implode('.', $keys), $val);
      
      $data[$first] = $val;
    } else {
      $data[$first] = $val;
    }
  }

  /**
   * Remove an array value
   * 
   * @param array $data
   * @param string|int $key
   * @return array
   */
  public static function remove(array &$data, string $key)
  {
    if(Arr::has($data, $key, false)) {
      unset($data[$key]);

      return $data;
    }

    if(is_int($key)) return $data;

    $keys  = explode('.', $key);
    $first = array_shift($keys);

    if(Arr::has($data, $first, false)) {
      if($keys) return Arr::remove($data[$first], implode('.', $keys));

      unset($data[$first]);
    }

    return $data;
  }

  /**
   * @param array ...$args
   * @return array
   */
  public static function plus(array ...$args) : array
  {
    $data = [];

    foreach($args as $arg)
      $data = $data + $arg;

    return $data;
  }

  /**
   * @param array $data
   * @return \ArrayIterator
   */
  public static function iterator(array $data = [])
  {
    return new ArrayIterator($data);
  }
}