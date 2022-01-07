<?php

namespace Seeren\Cache\Exception;

use Exception;

class InvalidArgumentException extends Exception implements \Psr\Cache\InvalidArgumentException
{
}
