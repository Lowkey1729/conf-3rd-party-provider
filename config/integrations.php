<?php

return [
    'dojah' => [
        'appId' => env('DOJAH_APP_ID'),
        'publicKey' => env('DOJAH_PUBLIC_KEY'),
        'privateKey' => env('DOJAH_PRIVATE_KEY'),
        'baseUrl' => env('DOJAH_BASE_URL'),
    ],
    'qoreId' => [
        'baseUrl' => env('QORE_ID_BASE_URL'),
        'clientId' => env('QORE_ID_CLIENT_ID'),
        'secretKey' => env('QORE_ID_SECRET_KEY'),
    ],
];
