<?php

namespace Maksym\Cache\Contracts;

use Exception;
use Maksym\Cache\Interfaces\CacheInterface;

class memcachedCacheDriver extends CacheInterface
{
    /** @var \Memcached */
    private $cache_container;

    /**
     * @param array $conf
     * @throws Exception
     */
    public function __construct(array $conf)
    {
        $servers_count = 0;
        if (!class_exists('\Memcached')) {
            throw new Exception("ext-memcached for php is not installed.");
        }
        $this->cache_container = new \Memcached();
        foreach ($conf as $connection) {
            if (isset($connection['server'], $connection['port'])) {
                $this->cache_container->addServer($connection['server'], $connection['port']);
                $servers_count++;
            }
        }
        //if (!$servers_count) { /* ??? */ }
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param int $seconds if 0 then unlimited
     * @return void
     */
    public function set($key, $value, $seconds = 0)
    {
        $this->cache_container->set($key, $value, $seconds);
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return array|mixed|string|null
     */
    public function get($key, $default = null)
    {
        $ret = $this->cache_container->get($key);
        return $ret === false ? $default : $ret;
    }

    /**
     * @param string $key
     * @return void
     */
    public function delete($key)
    {
        $this->cache_container->delete($key);
    }

    /**
     * @return bool
     */
    public function clearCache()
    {
        return $this->cache_container->flush();
    }

    /**
     *
     */
    public function __destruct()
    {
        $this->cache_container->quit();
    }
}