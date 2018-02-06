<?php 

namespace Waynestate\ImageFaker;

use \Illuminate\Support\Facades\Facade;

class ImageFakerFacade extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return ImageFaker::class;
    }
}
