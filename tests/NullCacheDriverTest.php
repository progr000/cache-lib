<?php

namespace Tests;

use Maksym\Cache\Interfaces\CacheInterface;
use Maksym\Cache\Providers\CacheProvider;
use Maksym\Config\ConfigException;

class NullCacheDriverTest extends _BaseTestCase
{
    /** @var CacheInterface */
    private static $instance;

    public static function setUpBeforeClass()
    {
        self::$conf['driver'] = 'null';
        config()->set('caching', self::$conf);
    }

    /**
     * @throws ConfigException
     */
    public function testConstructOk()
    {
        $cp = new CacheProvider();
        self::$instance = $cp->register();

        $this->assertInstanceOf('Maksym\Cache\Contracts\nullCacheDriver', self::$instance);
    }

    /**
     * @return void
     */
    public function testSet()
    {
        $ret = self::$instance->set('foo', 'bar');
        $this->assertTrue($ret);
    }

    /**
     * @return void
     */
    public function testGet()
    {
        $ret = self::$instance->get('foo');
        $this->assertNull($ret);
    }

    /**
     * @return void
     */
    public function testGetDefault()
    {
        $this->assertEquals('default', self::$instance->get('foo', 'default'));
    }

    /**
     * @return void
     */
    public function testDelete()
    {
        $ret = self::$instance->delete('foo');
        $this->assertTrue($ret);
        $this->assertNull(self::$instance->get('foo'));
    }

    /**
     * @return void
     */
    public function testClearCache()
    {
        $ret = self::$instance->clearCache();
        self::assertTrue($ret);
    }
}