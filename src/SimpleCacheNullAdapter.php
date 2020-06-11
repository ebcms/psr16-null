<?php declare (strict_types = 1);

namespace Ebcms;

use Psr\SimpleCache\CacheInterface;

class SimpleCacheNullAdapter implements CacheInterface
{
    public function get($key, $default = null)
    {
        $this->validateKey($key);
        return $default;
    }

    public function set($key, $value, $ttl = null): bool
    {
        $this->validateKey($key);
        return true;
    }

    public function delete($key): bool
    {
        $this->validateKey($key);
        return true;
    }

    public function clear(): bool
    {
        return true;
    }

    public function getMultiple($keys, $default = null): iterable
    {
        foreach ($keys as $key) {
            yield $key => $this->get($key, $default);
        }
    }

    public function setMultiple($values, $ttl = null): bool
    {
        foreach ($values as $key => $value) {
            if (!$this->set($key, $value, $ttl)) {
                return false;
            }
        }
        return true;
    }

    public function deleteMultiple($keys): bool
    {
        foreach ($keys as $key) {
            if (!$this->delete($key)) {
                return false;
            }
        }
        return true;
    }

    public function has($key): bool
    {
        $this->validateKey($key);
        return false;
    }

    /**
     * @param string $key
     *
     * @throws SimpleCacheInvalidArgumentException
     */
    protected function validateKey($key)
    {
        if (!is_string($key) || $key === '') {
            throw new SimpleCacheInvalidArgumentException('Key should be a non empty string');
        }

        $unsupportedMatched = preg_match('#[' . preg_quote('{}()/\@:') . ']#', $key);
        if ($unsupportedMatched > 0) {
            throw new SimpleCacheInvalidArgumentException('Can\'t validate the specified key');
        }

        return true;
    }
}
