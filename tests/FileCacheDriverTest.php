<?php

namespace Tests;

use Maksym\Cache\Interfaces\CacheInterface;
use Maksym\Cache\Providers\CacheProvider;
use Maksym\Config\ConfigException;

class FileCacheDriverTest extends _BaseTestCase
{
    /** @var CacheInterface */
    private static $instance;

    public static function setUpBeforeClass()
    {
        self::$conf['driver'] = 'file';
        config()->set('caching', self::$conf);
    }

    /**
     * @throws ConfigException
     * @ex
     */
    public function testConstructBadDir()
    {
        $this->expectException('Maksym\Config\ConfigException');
        $this->expectExceptionMessage('Directory for cache-driver not exist');

        self::$conf['file']['store_dir'] = '/ddd';
        config()->set('caching', self::$conf);

        $cp = new CacheProvider();
        self::$instance = $cp->register();
    }

    /**
     * @throws ConfigException
     */
    public function testConstructOk()
    {
        self::$conf['file']['store_dir'] = '/tmp/cache-lib-tests';
        config()->set('caching', self::$conf);

        $cp = new CacheProvider();
        self::$instance = $cp->register();

        $this->assertInstanceOf('Maksym\Cache\Contracts\fileCacheDriver', self::$instance);
    }

    /**
     * @return void
     */
    public function testSetGet()
    {
        self::$instance->set('foo', 'bar');
        $this->assertEquals('bar', self::$instance->get('foo'));
    }

    /**
     * @return void
     */
    public function testDelete()
    {
        self::$instance->delete('foo');
        $this->assertNull(self::$instance->get('foo'));
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
    public function testClearCache()
    {
        self::$instance->set('foo1', 'bar1');
        self::$instance->set('foo2', 'bar2');

        self::$instance->clearCache();
        $this->assertNull(self::$instance->get('foo1'));
        $this->assertNull(self::$instance->get('foo2'));
    }
}