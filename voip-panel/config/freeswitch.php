<?php

return [
    /*
    |--------------------------------------------------------------------------
    | FreeSWITCH Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for connecting to FreeSWITCH
    |
    */

    'host' => env('FREESWITCH_HOST', '127.0.0.1'),
    'port' => env('FREESWITCH_PORT', 8021),
    
    'esl_host' => env('FREESWITCH_ESL_HOST', '127.0.0.1'),
    'esl_port' => env('FREESWITCH_ESL_PORT', 8021),
    'esl_password' => env('FREESWITCH_PASSWORD', 'ClueCon'),
    
    'conf_path' => env('FREESWITCH_CONF_PATH', '/etc/freeswitch'),
    'sounds_path' => env('FREESWITCH_SOUNDS_PATH', '/usr/share/freeswitch/sounds'),
    'recordings_path' => env('FREESWITCH_RECORDINGS_PATH', '/var/lib/freeswitch/recordings'),
    
    'modules' => [
        'mod_esl',
        'mod_sofia',
        'mod_dialplan_xml',
        'mod_commands',
        'mod_db',
        'mod_dptools',
        'mod_callcenter',
        'mod_conference',
        'mod_verto',
        'mod_flite',
        'mod_pocketsphinx',
        'mod_lcr',
        'mod_nibblebill',
        'mod_easyroute',
        'mod_mariadb',
        'mod_odbc_cdr',
    ],
    
    'ai' => [
        'enabled' => env('AI_ENABLED', true),
        'mode' => env('AI_MODE', 'hybrid'), // human, ai, hybrid
        'openai_api_key' => env('OPENAI_API_KEY', ''),
        'model' => env('AI_MODEL', 'gpt-4'),
    ],
    
    'billing' => [
        'enabled' => env('BILLING_ENABLED', true),
        'default_rate' => env('DEFAULT_RATE_PER_MINUTE', 0.01),
    ],
    
    'video' => [
        'enabled' => env('VIDEO_ENABLED', true),
        'verto_ws_url' => env('VERTO_WS_URL', 'wss://127.0.0.1:8082'),
    ],
    
    'sms' => [
        'enabled' => env('SMS_ENABLED', true),
        'provider' => env('SMS_PROVIDER', 'signalwire'),
        'signalwire' => [
            'project_id' => env('SIGNALWIRE_PROJECT_ID', ''),
            'token' => env('SIGNALWIRE_TOKEN', ''),
            'space' => env('SIGNALWIRE_SPACE', ''),
        ],
    ],
];
