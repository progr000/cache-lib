<?php

namespace Maksym\Cache\Providers;

use Maksym\Config\ConfigDriver;
use Maksym\Config\ConfigException;

class CacheProvider
{
    /**
     * @param string|null $config_file
     * @return mixed
     * @throws ConfigException
     */
    public function register($config_file = null)
    {
        $config = ConfigDriver::getInstance($config_file);
        if (!$config->get('caching')) {
            throw new ConfigException(
                "You should setup configuration for cache lib. See example here: '" .
                realpath(__DIR__ . '/../config-example.php') .
                "'"
            );
        }
        $driver = $config->get('caching->driver', 'null');
        $className = "Maksym\\Cache\\Contracts\\{$driver}CacheDriver";
        if (class_exists($className)) {
            $cacheDriverCredentials = $config->get("caching->{$driver}", array());
            return new $className($cacheDriverCredentials);
        } else {
            throw new ConfigException('Cache driver not exist');
        }
    }
}