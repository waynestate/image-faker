<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Max image area in pixels.
    |--------------------------------------------------------------------------
    |
    | This is calculated by width * height. If a request tries to create a
    | larger image it will 404.
    |
    */
    'max_size' => 9000000,

    /*
    |--------------------------------------------------------------------------
    | Route path to generate images.
    |--------------------------------------------------------------------------
    |
    | Example route: /styleguide/image/100x100
    |
    */
    'route_path' => 'styleguide/image',

    /*
    |--------------------------------------------------------------------------
    | Hotlinking
    |--------------------------------------------------------------------------
    */
    'enable_hotlinking' => true,

    /*
    |--------------------------------------------------------------------------
    | Imagestring Font Size
    |--------------------------------------------------------------------------
    |
    | Font size allowed by the PHP imagestring function. Range 1-5.
    |
    */
    'imagestring_font' => 5,

    /*
    |--------------------------------------------------------------------------
    | Colors
    |--------------------------------------------------------------------------
    |
    | Set by the PHP imagecolorallocatealpha function.
    |
    */
    'colors' => [
        'background' => [
            'red' => 180,
            'green' => 180,
            'blue' => 180,
            'alpha' => 0,
        ],
        'text' => [
            'red' => 255,
            'green' => 255,
            'blue' => 255,
            'alpha' => 50,
        ],
    ],
];
