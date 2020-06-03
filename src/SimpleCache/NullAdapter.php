<?php

namespace Ebcms\SimpleCache;

use Ebcms\SimpleCache\Exception\InvalidArgumentException;
use Psr\SimpleCache\CacheInterface;

class NullAdapter implements CacheInterface
{
    public function get(string $key, $default = null)
    {
        $this->validateKey($key);
        return $default;
    }

    public function set(string $key, $value, $ttl = null): bool
    {
        $this->validateKey($key);
        return true;
    }

    public function delete(string $key): bool
    {
        $this->validateKey($key);
        return true;
    }

    public function clear(): bool
    {
        return true;
    }

    public function getMultiple(iterable $keys, $default = null): iterable
    {
        foreach ($keys as $key) {
            yield $key => $this->get($key, $default);
        }
    }

    public function setMultiple(iterable $values, $ttl = null): bool
    {
        foreach ($values as $key => $value) {
            if (!$this->set($key, $value, $ttl)) {
                return false;
            }
        }
        return true;
    }

    public function deleteMultiple(iterable $keys): bool
    {
        foreach ($keys as $key) {
            if (!$this->delete($key)) {
                return false;
            }
        }
        return true;
    }

    public function has(iterable $key): bool
    {
        $this->validateKey($key);
        return false;
    }

    /**
     * @param string $key
     *
     * @throws InvalidArgumentException
     */
    protected function validateKey($key)
    {
        if (!is_string($key)) {
            throw new InvalidArgumentException(sprintf(
                'Cache key must be string, "%s" given',
                gettype($key)
            ));
        }
        if (!isset($key[0])) {
            throw new InvalidArgumentException('Cache key cannot be an empty string');
        }
        if (preg_match('|[\{\}\(\)/\\\@\:]|', $key)) {
            throw new InvalidArgumentException(sprintf(
                'Invalid key: "%s". The key contains one or more characters reserved for future extension: {}()/\@:',
                $key
            ));
        }
    }
}