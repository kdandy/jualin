<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cloudinary Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your Cloudinary settings. Cloudinary is a cloud
    | service that offers a solution to a web application's entire image
    | management pipeline.
    |
    */

    'cloud_name' => env('CLOUDINARY_NAME'),
    'api_key' => env('CLOUDINARY_API_KEY'),
    'api_secret' => env('CLOUDINARY_API_SECRET'),
    'secure' => true,

    /*
    |--------------------------------------------------------------------------
    | Upload Settings
    |--------------------------------------------------------------------------
    |
    | These settings control the default upload behavior for Cloudinary.
    |
    */

    'upload_preset' => env('CLOUDINARY_UPLOAD_PRESET'),
    'folder' => env('CLOUDINARY_FOLDER', 'laravel-uploads'),
    
    /*
    |--------------------------------------------------------------------------
    | Transformation Settings
    |--------------------------------------------------------------------------
    |
    | Default transformation settings for uploaded images.
    |
    */

    'transformations' => [
        'quality' => 'auto',
        'fetch_format' => 'auto',
    ],
];