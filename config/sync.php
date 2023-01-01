<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Synology LDAP
    |--------------------------------------------------------------------------
    |
    | This option allows you to specify if you are using Synology's LDAP
    | implementation. This allows for the use of the Synology LDAP schema
    | and the use of the Synology LDAP API to get the next available UID
    | number.
    |
    */
    'synology' => env('LDAP_SYNOLOGY', true),

    /*
    |--------------------------------------------------------------------------
    | Sync Type
    |--------------------------------------------------------------------------
    |
    | This option allows you to specify the type of sync you would like to
    | perform. For Synology, you need at least posix for a user to be able
    | to login. For shared folder access you need both.
    |
    | Supported: "full", "samba", "posix"
    |
    */
    'sync_type' => env('LDAP_SYNC_TYPE', 'full'),

    'default_group' => env('LDAP_DEFAULT_GROUP', 'limited'),
];
