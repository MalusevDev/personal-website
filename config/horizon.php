<?php

return [
    'use' => 'horizon',

    'waits' => collect(explode(',', env('HORIZON_QUEUES', 'default,emails,notifications')))
        ->mapToDictionary(static fn(string $queue) => ['redis:' . $queue => 60])
        ->map(static fn(array $val) => $val[0])
        ->toArray(),

    'metrics' => [
        'trim_snapshots' => [
            'job' => 24,
            'queue' => 24,
        ],
    ],

    'memory_limit' => 128,

    'defaults' => [
        'supervisor-1' => [
            'connection' => 'redis',
            'queue' => explode(',', env('HORIZON_QUEUES', 'default,emails,notifications')),
            'balance' => 'auto',
            'autoScalingStrategy' => 'time',
            'maxProcesses' => 1,
            'maxTime' => 0,
            'maxJobs' => 0,
            'memory' => 128,
            'tries' => 1,
            'timeout' => 10,
            'nice' => 0,
        ],
    ],

    'environments' => [
        'production' => [
            'supervisor-1' => [
                'maxProcesses' => 10,
                'tries' => 3,
                'timeout' => 60,
                'balanceMaxShift' => 1,
                'balanceCooldown' => 3,
            ],
        ],

        'local' => [
            'supervisor-1' => [
                'maxProcesses' => 3,
            ],
        ],
    ],
];
