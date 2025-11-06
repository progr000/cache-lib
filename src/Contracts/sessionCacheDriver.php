<?php

namespace Maksym\Cache\Contracts;

use Maksym\Cache\Interfaces\CacheInterface;
use Maksym\SessCook\SessionDriver;

class sessionCacheDriver extends CacheInterface
{
    /** @var array */
    private $cache_container;

    /**
     * @param array $conf
     */
    public function __construct(array $conf)
    {
        $this->cache_container = SessionDriver::getInstance('cache-container');
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param int $seconds if 0 then unlimited
     * @return bool
     */
    public function set($key, $value, $seconds = 0)
    {
        if ($seconds) {
            $die_after = time() + $seconds;
        } else {
            $die_after = false;
        }
        return $this->cache_container->set($key, array(
            'value' => $value,
            'die_after' => $die_after
        ));
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $data = $this->cache_container->get($key, $default);
        if ($data) {
            if ($data['die_after']) {
                if ($data['die_after'] >= time()) {
                    return $data['value'];
                } else {
                    $this->delete($key);
                }
            } else {
                return $data['value'];
            }
        }

        return $default;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function delete($key)
    {
        return $this->cache_container->delete($key);
    }

    /**
     * @return void
     */
    public function clearCache()
    {
        return $this->cache_container->clear();
    }
}