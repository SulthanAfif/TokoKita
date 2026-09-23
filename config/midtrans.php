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
    | PENTING: env boolean di Vercel adalah string ("false"/"true").
    | Harus di-cast dengan filter_var, kalau tidak "false" dianggap true di PHP.
    |
    */

    'merchant_id' => env('MIDTRANS_MERCHANT_ID'),

    'client_key' => env('MIDTRANS_CLIENT_KEY'),

    'server_key' => env('MIDTRANS_SERVER_KEY'),

    // Cast ketat: "false", "0", "no", "" → false
    'is_production' => filter_var(env('MIDTRANS_IS_PRODUCTION', false), FILTER_VALIDATE_BOOLEAN),

    'is_sanitized' => true,

    'is_3ds' => true,

    /*
    |--------------------------------------------------------------------------
    | Snap JS URL + API URL (ikuti is_production yang sudah di-cast)
    |--------------------------------------------------------------------------
    */
    'snap_js_url' => filter_var(env('MIDTRANS_IS_PRODUCTION', false), FILTER_VALIDATE_BOOLEAN)
        ? 'https://app.midtrans.com/snap/snap.js'
        : 'https://app.sandbox.midtrans.com/snap/snap.js',

    'api_url' => filter_var(env('MIDTRANS_IS_PRODUCTION', false), FILTER_VALIDATE_BOOLEAN)
        ? 'https://app.midtrans.com/snap/v1'
        : 'https://app.sandbox.midtrans.com/snap/v1',
];
