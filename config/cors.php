<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Laravel CORS
     |--------------------------------------------------------------------------
     |
     | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
     | to accept any value.
     |
     */

    'supportsCredentials' => true,
    'allowedOrigins' => env('CORS_ALLOWED_ORIGINS') ? explode(',', env('CORS_ALLOWED_ORIGINS')) : ['*'],
    'allowedHeaders' => ['Content-Type', 'Accept', 'X-Requested-With', 'Authorization'],
    'allowedMethods' => ['*'],
    'exposedHeaders' => [],
    'paths' => ['api/*'],
    'maxAge' => 864000,
];

