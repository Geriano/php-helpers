<?php

namespace Geriano\Helpers;

class Arr
{
  /**
   * Wrap item to array
   */
  public static function wrap($items = null) : array 
  {
    if(is_null($items)) return [];
    if(is_array($items)) return $items;

    return [$items];
  }

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

    if(strpos($key, '.') != false) return Arr::dot($data, $key);

    return $default;
  }

  /**
   * @param array $data
   * @param string $key 
   * @param mixed $default
   * @return mixed
   */
  protected static function dot(array $data, string $key, $default = null)
  {
    $keys  = explode('.', trim($key, '.'));
    $first = array_shift($keys);

    if($keys) return Arr::get($data[$first], implode('.', $keys), $default);
    
    return Arr::get($data, $first, $default);
  }

  /**
   * Plus array
   * 
   * @return array
   */
  public static function plus(array ...$parameters)
  {
    $result = [];

    foreach($parameters as $arr) {
      $result = $result + $arr;
    }

    return $result;
  }
}