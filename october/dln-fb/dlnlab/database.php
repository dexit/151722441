<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | PDO Fetch Style
    |--------------------------------------------------------------------------
    |
    | By default, database results will be returned as instances of the PHP
    | stdClass object; however, you may desire to retrieve records in an
    | array format for simplicity. Here you can tweak the fetch style.
    |
    */

    'fetch' => PDO::FETCH_CLASS,

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => 'mysql',

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => array(

        'sqlite' => array(
            'driver'   => 'sqlite',
            'database' => 'database/production.sqlite',
            'prefix'   => '',
        ),

        'mysql' => array(
            'driver'    => 'mysql',
            'host'      => 'mysql.hostinger.vn',
            'port'      => 3306,
            'database'  => 'u980825196_oct',
            'username'  => 'u980825196_admin',
            'password'  => 'admin@123',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ),

        'pgsql' => array(
            'driver'   => 'pgsql',
            'host'     => 'localhost',
            'port'     => '',
            'database' => 'database',
            'username' => 'root',
            'password' => '',
            'charset'  => 'utf8',
            'prefix'   => '',
            'schema'   => 'public',
        ),

        'sqlsrv' => array(
            'driver'   => 'sqlsrv',
            'host'     => 'localhost',
            'port'     => '',
            'database' => 'database',
            'username' => 'root',
            'password' => '',
            'prefix'   => '',
        ),

    ),

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk have not actually be run in the databases.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => array(

        'cluster' => false,

        'default' => array(
            'host'     => '127.0.0.1',
            'port'     => 6379,
            'database' => 'u848275323_oct',
        ),

    ),

);
