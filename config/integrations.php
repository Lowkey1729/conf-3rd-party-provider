<?php

return [
    'dojah' => [
        'appId' => env('DOJAH_APP_ID'),
        'publicKey' => env('DOJAH_PUBLIC_KEY'),
        'privateKey' => env('DOJAH_PRIVATE_KEY'),
        'baseUrl' => env('DOJAH_BASE_URL'),
    ],

    'sagecloud' => [
        'baseUrl' => env('SAGECLOUD_BASE_URL'),
        'publicKey' => env('SAGECLOUD_PUBLIC_KEY'),
        'secretKey' => env('SAGECLOUD_SECRET_KEY'),
        'email' => env('SAGECLOUD_EMAIL'),
        'password' => env('SAGECLOUD_PASSWORD'),
        'signature' => env('SAGECLOUD_SIGNATURE'),
    ],

    'lydiaCollect' => [
        'baseUrl' => env('LYDIA_COLLECT_BASE_URL'),
        'username' => env('LYDIA_COLLECT_USERNAME'),
        'password' => env('LYDIA_COLLECT_PASSWORD'),
        'defaultEnterpriseId' => env('LYDIA_COLLECT_DEFAULT_ENTERPRISE_ID'),
    ],

    'recova' => [
        'baseUrl' => env('RECOVA_BASE_URL'),
        'apiToken' => env('RECOVA_API_TOKEN'),
    ],

    'idrs' => [
        'baseUrl' => env('IDRS_BASE_URL'),
    ],
    'qoreId' => [
        'baseUrl' => env('QORE_ID_BASE_URL'),
        'clientId' => env('QORE_ID_CLIENT_ID'),
        'secretKey' => env('QORE_ID_SECRET_KEY'),
    ],
];
