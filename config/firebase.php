<?php
return [
    'default' => env('FIREBASE_PROJECT_ID', 'default_project_id'), // Set project ID

    'projects' => [
        env('FIREBASE_PROJECT_ID') => [
            'credentials' => storage_path(env('FIREBASE_CREDENTIALS')), // Convert relative path to absolute path
            'database_url' => env('FIREBASE_DATABASE_URL'),

            'auth' => [
                'api_key' => env('FIREBASE_API_KEY'),
                'auth_domain' => env('FIREBASE_AUTH_DOMAIN'),
            ],

            'storage' => [
                'bucket' => env('FIREBASE_STORAGE_BUCKET'),
            ],

            'messaging' => [
                'sender_id' => env('FIREBASE_MESSAGING_SENDER_ID'),
            ],

            'app' => [
                'app_id' => env('FIREBASE_APP_ID'),
                'measurement_id' => env('FIREBASE_MEASUREMENT_ID'),
            ],
        ],
    ],
];
?>
