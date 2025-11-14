<?php
return array(
    /*
    |--------------------------------------------------------------------------
    | Set here what driver for cache you want to use
    |--------------------------------------------------------------------------
    |
    | null - this driver doesn't cache anything, but you can use it as plug for debug without cache, and then simple switch to another driver
    | session - this driver use php-session mechanism. Important: this driver not suitable for work with console scripts ($_SESSION doesn't exist in console)
    | file - this driver use filesystem. You can specify credential for this driver 'file'=>array('store_dir'=>"/path/to/folder/where/cache/will/be/stored")
    | memcache - this driver use memcache server. You need to specify at least one memcache-server and port: 'memcached'=>array(array('server'=>'ip_or_name', 'port'=>'num'),...)
    |
    */
    'driver' => 'file',

    /* credentials for file-driver (store_dir should be defined and has rw-access for write for store data) */
    'file' => array(
        'store_dir' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid(),
    ),

    /* credential for memcached-driver (you can add several servers) */
    'memcached' => array(
        array('server' => 'ip-address','port' => '11211'),
        // ['server' => 'server-2','port' => 'port-2'],
        // ....
        // ['server' => 'server-N','port' => 'port-N'],
    ),
);
