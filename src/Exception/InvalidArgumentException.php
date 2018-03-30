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
    * @param string $message
    * @param int $code
    * @param Exception $previous
    */
   public function __construct(
       string $message,
       int $code = E_NOTICE,
       Exception $previous = null)
   {
       parent::__construct($message, $code, $previous);
   }

}
