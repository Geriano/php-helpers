<?php

namespace Geriano\Helpers;

class Str
{
  /**
   * Generate random string
   * 
   * @param int $length
   */
  public static function random(int $length = 16, bool $number = true)
  {
    $result = '';

    foreach(range(1, $length) as $i) {
      $generated = [
        // lower case
        rand(ord('a'), ord('z')),

        // upper case
        rand(ord('A'), ord('Z')),

        rand(ord('0'), ord('9'))
      ];

      $result .= sprintf('%c', $generated[rand(0, $number ? 2 : 1)]);
    }

    return $result;
  }
}