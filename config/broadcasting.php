<?php

use GuzzleHttp\RequestOptions;

return [
    'connections' => [
        'pusher' => [
            'client_options' => [
                RequestOptions::SYNCHRONOUS => false,
                RequestOptions::TIMEOUT => 1,
            ],
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'broadcasting',
        ],
    ],
];
