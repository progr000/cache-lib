<?php

namespace Tests;

use Maksym\Cache\Interfaces\CacheInterface;
use Maksym\Cache\Providers\CacheProvider;
use Maksym\Config\ConfigException;

class CacheProviderTest extends _BaseTestCase
{
    /** @var CacheInterface */
    private static $instance;

    /**
     * @throws ConfigException
     */
    public function testRegister()
    {
        $cp = new CacheProvider();
        self::$instance = $cp->register();

        //$this->assertInstanceOf('Maksym\Cache\Providers\CacheProvider', $cp);
        $this->assertInstanceOf('Maksym\Cache\Interfaces\CacheInterface', self::$instance);
    }
}