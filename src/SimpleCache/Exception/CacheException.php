<?php

namespace Ebcms\SimpleCache\Exception;

use \Psr\SimpleCache\CacheException as PsrCacheException;
use \Exception;

class CacheException extends Exception implements PsrCacheException
{
}
