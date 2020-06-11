<?php declare (strict_types = 1);

namespace Ebcms;

use \Psr\SimpleCache\InvalidArgumentException as SimpleCacheInvalidArgumentExceptionInterface;

class SimpleCacheInvalidArgumentException extends SimpleCacheException implements SimpleCacheInvalidArgumentExceptionInterface
{
}
