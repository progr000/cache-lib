<?php

namespace Tests;

use Maksym\Config\ConfigDriver;
use Maksym\Config\ConfigException;
use PHPUnit\Framework\TestCase;

abstract class _BaseTestCase extends TestCase
{
    /** @var array */
    protected static $conf;

    /**
     * @return void
     * @throws ConfigException
     */
    public static function setUpBeforeClass()
    {
        ConfigDriver::getInstance(__DIR__ . DIRECTORY_SEPARATOR . "config/main.php");
        self::$conf = config()->get('caching');
    }
}
