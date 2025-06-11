<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Configuration de l'optimisation des assets
    |--------------------------------------------------------------------------
    |
    | Ce fichier contient la configuration pour l'optimisation des assets
    | (images, CSS, JS, HTML) de l'application.
    |
    */

    'enabled' => env('ASSET_OPTIMIZATION_ENABLED', true),

    'image' => [
        'max_width' => env('ASSET_IMAGE_MAX_WIDTH', 800),
        'max_height' => env('ASSET_IMAGE_MAX_HEIGHT', 600),
        'quality' => env('ASSET_IMAGE_QUALITY', 80),
        'format' => env('ASSET_IMAGE_FORMAT', 'jpg'),
        'driver' => env('ASSET_IMAGE_DRIVER', 'gd'),
    ],

    'css' => [
        'minify' => env('ASSET_CSS_MINIFY', true),
        'remove_comments' => env('ASSET_CSS_REMOVE_COMMENTS', true),
        'remove_last_semicolon' => env('ASSET_CSS_REMOVE_LAST_SEMICOLON', true),
    ],

    'js' => [
        'minify' => env('ASSET_JS_MINIFY', true),
        'remove_comments' => env('ASSET_JS_REMOVE_COMMENTS', true),
        'remove_last_semicolon' => env('ASSET_JS_REMOVE_LAST_SEMICOLON', true),
    ],

    'html' => [
        'minify' => env('ASSET_HTML_MINIFY', true),
        'remove_comments' => env('ASSET_HTML_REMOVE_COMMENTS', true),
        'remove_attributes' => env('ASSET_HTML_REMOVE_ATTRIBUTES', true),
    ],

    'output' => [
        'directory' => env('ASSET_OUTPUT_DIRECTORY', 'optimized'),
        'preserve_structure' => env('ASSET_PRESERVE_STRUCTURE', true),
    ],
]; 