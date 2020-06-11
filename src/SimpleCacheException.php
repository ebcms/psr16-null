<?php declare (strict_types = 1);

namespace Ebcms;

use Exception;
use Psr\SimpleCache\CacheException as SimpleCacheExceptionInterface;

class SimpleCacheException extends Exception implements SimpleCacheExceptionInterface
{
}
