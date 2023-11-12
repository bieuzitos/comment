<?php

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
*/

require __DIR__ . '/vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Application Environment
|--------------------------------------------------------------------------
*/

\Dotenv\Dotenv::createUnsafeImmutable(__DIR__)->load();

/*
|--------------------------------------------------------------------------
| Phinx Configuration
|--------------------------------------------------------------------------
*/

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/database/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/database/seeders'
    ],

    'environments' => [
        'default_migration_table' => '_phinxlog',
        'default_environment' => 'development',

        'production' => [
            'adapter' => 'mysql',
            'host' => 'localhost',
            'port' => '3306',
            'name' => 'production_db',
            'user' => 'root',
            'pass' => '',
            'charset' => 'utf8',
        ],

        'development' => [
            'adapter' => $_ENV['DB_CONNECTION'],
            'host' => $_ENV['DB_HOST'],
            'port' => $_ENV['DB_PORT'],
            'name' => $_ENV['DB_DATABASE'],
            'user' => $_ENV['DB_USERNAME'],
            'pass' => $_ENV['DB_PASSWORD'],
            'charset' => 'utf8',
        ],
    ],
    
    'version_order' => 'creation'
];