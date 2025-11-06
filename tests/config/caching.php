<?php
return array(
    /*
    |--------------------------------------------------------------------------
    | Set here what driver for cache you want to use
    |--------------------------------------------------------------------------
    |
    | null - this driver doesn't cache anything, but you can use it as plug for debug without cache
    | session - this driver use php-session mechanism
    | file - this driver use filesystem
    | memcache - this driver use memcache server
    |
    */
    'driver' => 'session',

    /* credentials for null-driver (can be empty) */
    'null' => array(),

    /* credentials for session-driver (can be empty) */
    /* important: this driver not suitable for work with console scripts ($_SESSION doesn't exist in console) */
    'session' => array(),

    /* credentials for file-driver (store_dir should be defined and has rw-access for write for store data) */
    'file' => array(
        'store_dir' => '/tmp/cache-lib-tests'
    ),

    /* credential for memcached-driver (you can add several servers) */
    'memcached' => array(
        array('server' => 'whm-memcached','port' => '11211'),
        // ['server' => 'server-2','port' => 'port-2'],
        // ....
        // ['server' => 'server-N','port' => 'port-N'],
    )
);
