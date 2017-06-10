<?php

/**
 * This file contain Seeren\Cache\Exception\InvalidArgumentException class
 *     __
 *    / /__ __ __ __ __ __
 *   / // // // // // // /
 *  /_// // // // // // /
 *    /_//_//_//_//_//_/
 *
 * @copyright (c) Cyril Ichti <consultant@seeren.fr>
 * @link https://github.com/seeren/cache
 * @version 1.0.1
 */

namespace Seeren\Cache\Exception;

use Psr\Cache\InvalidArgumentException as PsrInvalidArgumentException;
use Exception;

/**
 * Class for represent an invalid argument exception
 * 
 * @category Seeren
 * @package Cache
 * @subpackage Exception
 */
class InvalidArgumentException extends Exception implements
    PsrInvalidArgumentException
{

   /**
    * Construct InvalidArgumentException
    * 
    * @param string $message message
    * @param int $code code
    * @param Exception $previous previous exception
    * @return null
    */
   public function __construct(
       string $message,
       int $code = E_NOTICE,
       Exception $previous = null)
   {
       parent::__construct($message, $code, $previous);
   }

}
