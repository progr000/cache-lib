<?php

namespace Maksym\Cache\Providers;

use Maksym\Config\ConfigDriver;
use Maksym\Config\ConfigException;

class CacheProvider
{
    /**
     * @throws ConfigException
     */
    public function register()
    {
        $config = ConfigDriver::getInstance("");
        $driver = $config->get('caching->driver', 'session');
        $className = "Core\\Contracts\\CacheDrivers\\{$driver}CacheDriver";
        if (class_exists($className)) {
            $cacheDriverCredentials = $config->get("caching->{$driver}", array());
            return new $className($cacheDriverCredentials);
        } else {
            throw new ConfigException('Cache driver not exist');
        }
    }
}