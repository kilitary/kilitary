<?php
declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => [],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'https://crm.dev.salamport.ru', 'localhost', '127.0.0.1',
        'https://localhost:8080', 'http://localhost:8080',
        'https://ab40859c75f0.ngrok.io', '192.168.10.*', 'api.int', 'http://172.30.0.239:8000',
        'http://localhost:80', 'https://localhost', '*.ngrok.io', 'https://efimov-test.tesonero.com', 'kilitary.int'
    ],

    'allowed_origins_patterns' => ['*'],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
