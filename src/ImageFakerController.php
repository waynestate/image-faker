<?php

namespace Waynestate\ImageFaker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImageFakerController extends Controller
{
    /**
     * Construct the ImageFakerController.
     *
     * @param ImageFaker $image
     */
    public function __construct(ImageFaker $image)
    {
        $this->image = $image;
    }
    /**
     * Display an example accordion.
     *
     * @param Request $request
     * @return image/png
     */
    public function index(Request $request)
    {
        $dimensions = $this->image->dimensions($request->size);

        if (! $this->image->onSameHost('https://'.$request->server('HTTP_HOST'), $request->server('HTTP_REFERER'))) {
            return abort('404');
        }

        if (! $this->image->reasonableSize($dimensions)) {
            return abort('404');
        }

        $image = $this->image->create($dimensions['width'], $dimensions['height'], $request->text);

        header("Content-Type: image/png");
        imagepng($image);
        imagedestroy($image);

        return response(200);
    }
}
