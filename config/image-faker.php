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
    | Font Size
    |--------------------------------------------------------------------------
    |
    | If GD FreeType library is available imagettftext is used to allow more
    | variable font sizes. Otherwise it will fall back to using imagestring
    | which allows for a range of only 1-5.
    |
    */
    'font_size' => 25,

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
