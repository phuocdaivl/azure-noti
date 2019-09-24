<?php

return [
    'connection_string' => env('AZ_CONNECTION_STRING'),
    'hub_path'  => env('AZ_HUB_PATH'),
    'token_ttl' => env('AZ_AUTHORIZATION_TTL', 60)
];