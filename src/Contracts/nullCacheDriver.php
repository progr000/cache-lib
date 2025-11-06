<?php

namespace Maksym\Cache\Contracts;

use Maksym\Cache\Interfaces\CacheInterface;

class nullCacheDriver extends CacheInterface
{
    /**
     * @param array $conf
     */
    public function __construct(array $conf)
    {
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param int $seconds if 0 then unlimited
     * @return bool
     */
    public function set($key, $value, $seconds = 0)
    {
        return true;
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return $default;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function delete($key)
    {
        return true;
    }

    /**
     * @return bool
     */
    public function clearCache()
    {
        return true;
    }
}