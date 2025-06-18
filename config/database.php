<?php


$options = [
    'default' => env('DB_CONNECTION', 'mysql'),

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_DB', 0),
        ],

        'cache' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_CACHE_DB', 1),
        ],

    ],

    'migrations' => 'migrations',

    'connections' => [

    ],
];

$env = env('APP_ENV');

if(in_array($env, ['production', 'stage'])){
    $options['redis'] = [

        'client' => env('REDIS_CLIENT', 'predis'),
        'cluster' => true,

        'clusters' => [
            'cache' => [
                env('REDIS_HOST', 'localhost').':'.env('REDIS_PORT', 6379)
            ],
            'options' => [ // Clustering specific options
                'cluster' => 'redis', // This tells Redis Client lib to follow redirects (from cluster)
                'ssl' => [
                    'cafile' => env('DSN_DB_CA_CRT', "/var/www/html/.yandex/root.crt"),
                    'verify_peer' => true
                ],
                'parameters' => [
                    'password' => env('REDIS_PASSWORD')
                ]
            ]
        ],
    ];
}

return $options;
