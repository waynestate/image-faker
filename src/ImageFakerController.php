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

        ob_start();
        imagepng($image);
        $image_data = ob_get_contents();
        imagedestroy($image);
        ob_end_clean();
        
        return response($image_data, 200, [
            'Content-Type' => 'image/png'
        ]);
    }
}
