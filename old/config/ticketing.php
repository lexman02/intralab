<?php

return [
    'platform' => env('TICKETING_PLATFORM', 'none'),

    'osticket_base_url' => env('OSTICKET_BASE_URL', null),

    'osticket_api_key' => env('OSTICKET_API_KEY', null),

    'subject_placeholder' => 'Whats going on? Be as descriptive as possible and include any error messages you see.',
];
