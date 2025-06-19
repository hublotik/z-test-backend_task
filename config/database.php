<?php


$options = [
    'default' => env('DB_CONNECTION', 'mysql'),

    'migrations' => 'migrations',

    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', 'host.docker.internal'),
            'port' => env('DB_PORT', '3308'),
            'database' => env('DB_DATABASE', 'tender_db'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', 'secret'),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => [],
        ],
    ],
];

$env = env('APP_ENV');

return $options;
