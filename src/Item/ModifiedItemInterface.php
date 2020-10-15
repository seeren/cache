<?php

namespace Seeren\Cache\Item;

use Psr\Cache\CacheItemInterface;

/**
 * Interface to represent a modified item
 *
 *     __
 *    / /__ __ __ __ __ __
 *   / // // // // // // /
 *  /_// // // // // // /
 *    /_//_//_//_//_//_/
 *
 * @package Seeren\Cache\Item
 */
interface ModifiedItemInterface extends CacheItemInterface
{

    /**
     * Get the last GMT date of modification
     *
     * @return string
     */
   public function last(): string;

}
