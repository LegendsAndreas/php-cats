<?php
return [
    'debug' => filter_var(env('DEBUG', true), FILTER_VALIDATE_BOOLEAN),

    'Session' => [
        'defaults' => 'php',
        'cookie' => 'CAKEPHP_SESSION', // Should match CSRF cookie
        'timeout' => 1440, // Session expiry (in minutes)
    ],

    'Security' => [
        'salt' => env('SECURITY_KEY', 'un-secure-string'),
        'cookieKey' => env('COOKIE_KEY', 'un-secure-string'),
    ],

    'Datasources' => [
        'default' => [
            'host' => env('DATABASE_HOST', 'piss'),
            'username' => env('DATABASE_USERNAME', 'pisster'),
            'password' => env('DATABASE_PASSWORD', ''),
            'database' => env('DATABASE_NAME', 'my_app'),
            'url' => env('DATABASE_URL', null),
        ],
        'test' => [
            'host' => 'localhost',
            //'port' => 'non_standard_port_number',
            'username' => 'my_app',
            'password' => 'secret',
            'database' => 'test_myapp',
            //'schema' => 'myapp',
            'url' => env('DATABASE_TEST_URL', 'sqlite://127.0.0.1/tmp/tests.sqlite'),
        ],
    ],

    'EmailTransport' => [
        'default' => [
            'host' => 'localhost',
            'port' => 25,
            'username' => null,
            'password' => null,
            'client' => null,
            'url' => env('EMAIL_TRANSPORT_DEFAULT_URL', null),
        ],
    ],
];
