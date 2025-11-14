<?php

namespace Maksym\Cache\Contracts;

use Maksym\Config\ConfigException;
use Maksym\Cache\Interfaces\CacheInterface;

class fileCacheDriver extends CacheInterface
{
    /** @var string */
    private $cache_container;

    /**
     * @param array $conf
     * @throws ConfigException
     */
    public function __construct(array $conf)
    {
        if (!isset($conf['store_dir'])) {
            $conf['store_dir'] = sys_get_temp_dir() . DIRECTORY_SEPARATOR . "cache_" . uniqid();
        }
        $this->cache_container = $conf['store_dir'];
        if (!file_exists($this->cache_container)) {
            @mkdir($this->cache_container, 0700, true);
        }
        @chmod($this->cache_container, 0700);
        if (!file_exists($this->cache_container) || !is_dir($this->cache_container)) {
            throw new ConfigException('Directory for cache-driver not exist');
        }
        if (!is_writable($this->cache_container)) {
            throw new ConfigException('Directory for cache-driver not writeable');
        }
    }

    /**
     * @param string $key
     * @return string
     */
    private function filenameByKey($key)
    {
        return $this->cache_container . "/cache-" . md5($key);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param int $seconds if 0 then unlimited
     * @return bool
     */
    public function set($key, $value, $seconds = 0)
    {
        $file = $this->filenameByKey($key);
        if (file_exists($file)) {
            @unlink($file);
        }
        if ($seconds) {
            $die_after = time() + $seconds;
        } else {
            $die_after = false;
        }
        $ret = file_put_contents($file, serialize(array(
            'value' => $value,
            'die_after' => $die_after
        )));
        chmod($file, 0600);

        return $ret;
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $file = $this->filenameByKey($key);
        if (file_exists($file)) {
            $data = unserialize(file_get_contents($file));
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
        }

        return $default;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function delete($key)
    {
        return @unlink($this->filenameByKey($key));
    }

    /**
     * @return bool
     */
    public function clearCache()
    {
        $files = array_diff(scandir($this->cache_container), array('.', '..'));
        $ret = true;
        foreach ($files as $file) {
            if (!is_dir("{$this->cache_container}/{$file}")) {
                $ret = $ret && @unlink("{$this->cache_container}/{$file}");
            }
        }

        return $ret;
    }
}