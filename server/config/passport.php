<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/16
 * Time: 11:16
 */

return [
    'proxy' =>
        [
            'grant_type' => env('OAUTH_GRANT_TYPE'),
            'client_id' => env('OAUTH_CLIENT_ID'),
            'client_secret' => env('OAUTH_CLIENT_SECRET'),
            'scope' => env('OAUTH_SCOPE', '*'),
        ],
    'refresh' =>
        [
            'grant_type' => env('OAUTH_GRANT_TYPE_REFRESH'),
            'client_id' => env('OAUTH_CLIENT_ID'),
            'client_secret' => env('OAUTH_CLIENT_SECRET'),
            'scope' => env('OAUTH_SCOPE', '*'),
        ]
];