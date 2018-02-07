# image-faker
A simple fake image generator using the PHP GD library. Generates images on the fly by referencing a route.

## Installation
You can install the package via composer:

```
composer require waynestate/image-faker
```

The package will automatically register itself if you are using laravel.

## Requirements

* GD library
* FreeType library (optional, will fall back to using imagestring over imagettftext)

## Demo

```
<img src="/styleguide/image/100x100" alt="">
```


## Publishing the config

```
php artisan vendor:publish --tag=image-faker
```

## Not using laravel?

Refer to the `src/ImageFakeController.php` to see an example of how to interact with the `image-faker` API.
