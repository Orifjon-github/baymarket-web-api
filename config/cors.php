<?php

return [
    /*
     * The path to send CORS preflight requests to. You should typically leave this
     * value set to its default value unless you have a specific need to change it.
     */
    'paths' => ['api/*'],

    /*
     * The list of request methods that are allowed by the CORS policy.
     */
    'allowed_methods' => ['*'],

    /*
     * The list of headers that are allowed by the CORS policy.
     */
    'allowed_headers' => ['*'],
    
    'allowed_origins' => [
    'http://localhost:3000',
],

    /*
     * The list of response headers that are exposed by the CORS policy.
     */
    'exposed_headers' => [],

    /*
     * The number of seconds that the browser should cache preflight requests.
     */
    'max_age' => 0,

    /*
     * Indicates whether cookies should be allowed to be submitted across CORS requests.
     */
    'supports_credentials' => true,
];

