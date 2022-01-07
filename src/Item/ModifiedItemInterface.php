<?php

namespace Seeren\Cache\Item;

use Psr\Cache\CacheItemInterface;

interface ModifiedItemInterface extends CacheItemInterface
{

    public function last(): string;

}
