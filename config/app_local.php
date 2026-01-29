<?php
return [
    'debug' => getenv('DEBUG') ?? true,

    'Session' => [
        'defaults' => 'php',
        'cookie' => 'CAKEPHP_SESSION', // Should match CSRF cookie
        'timeout' => 1440, // Session expiry (in minutes)
    ],

    'Security' => [
        'salt' => getenv('SECURITY_KEY') ?? 'un-secure-string',
        'cookieKey' => getenv('COOKIE_KEY') ?? 'un-secure-string',
    ],

    'Datasources' => [
        'default' => [
            'host' => getenv('DATABASE_HOST') ?? "piss",
            'username' => getenv('DATABASE_USERNAME') ?? 'pisster',
            'password' => getenv('DATABASE_PASSWORD') ?? "",
            'database' => getenv('DATABASE_NAME') ?? 'my_app',
            'url' => getenv('DATABASE_URL') ?? null,
        ],
        'test' => [
            'host' => 'localhost',
            //'port' => 'non_standard_port_number',
            'username' => 'my_app',
            'password' => 'secret',
            'database' => 'test_myapp',
            //'schema' => 'myapp',
            'url' => getenv('DATABASE_TEST_URL') ?? 'sqlite://127.0.0.1/tmp/tests.sqlite',
        ],
    ],
];
