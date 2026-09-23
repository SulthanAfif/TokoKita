<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Midtrans Configuration
    |--------------------------------------------------------------------------
    |
    | Ambil Server Key & Client Key dari dashboard Midtrans:
    | Settings → Access Keys (pastikan mode Sandbox)
    |
    */

    'merchant_id' => env('MIDTRANS_MERCHANT_ID'),

    'client_key' => env('MIDTRANS_CLIENT_KEY'),

    'server_key' => env('MIDTRANS_SERVER_KEY'),

    // true = sandbox (testing), false = production
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),

    // true = tampilkan log request/response Midtrans
    'is_sanitized' => true,

    'is_3ds' => true,

    /*
    |--------------------------------------------------------------------------
    | Snap JS URL
    |--------------------------------------------------------------------------
    */
    'snap_js_url' => env('MIDTRANS_IS_PRODUCTION', false)
        ? 'https://app.midtrans.com/snap/snap.js'
        : 'https://app.sandbox.midtrans.com/snap/snap.js',

    /*
    |--------------------------------------------------------------------------
    | API Base URL
    |--------------------------------------------------------------------------
    */
    'api_url' => env('MIDTRANS_IS_PRODUCTION', false)
        ? 'https://app.midtrans.com/snap/v1'
        : 'https://app.sandbox.midtrans.com/snap/v1',
];
