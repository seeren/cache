<?php

/**
 *     __
 *    / /__ __ __ __ __ __
 *   / // // // // // // /
 *  /_// // // // // // /
 *    /_//_//_//_//_//_/
 *
 * @author (c) Cyril Ichti <consultant@seeren.fr>
 * @link https://github.com/seeren/cache
 * @version 1.0.1
 */

namespace Seeren\Cache\Item;

/**
 * Interface for represent a modified item
 * 
 * @category Seeren
 * @package Cache
 * @subpackage Item
 */
interface ModifiedItemInterface
{

   /**
    * Set or get date of last modification
    *
    * @param int $timeStamp timeStamp of last modification
    * @return string GMT of last modification
    */
   public function last(int $timeStamp): string;

}
