<?php

namespace Seeren\Cache\Exception;

use Psr\Cache\InvalidArgumentException as PsrInvalidArgumentException;
use Exception;

/**
 * Class to represent an InvalidArgumentException
 *
 *     __
 *    / /__ __ __ __ __ __
 *   / // // // // // // /
 *  /_// // // // // // /
 *    /_//_//_//_//_//_/
 *
 * @package Seeren\Cache\Exception
 */
class InvalidArgumentException extends Exception implements PsrInvalidArgumentException
{

    /**
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct(string $message, int $code = E_NOTICE, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
