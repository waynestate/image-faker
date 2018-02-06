<?php

// Images
Route::get(config('image-faker.route_path').'/{size}', '\Waynestate\ImageFaker\ImageFakerController@index')
    ->where('size', '[0-9]+x[0-9]+')
    ->name('image');
