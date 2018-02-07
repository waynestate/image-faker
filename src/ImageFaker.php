<?php

namespace Waynestate\ImageFaker;

class ImageFaker
{
    /**
     * Construct the image faker.
     *
     * @param array $config
     * @return void
     */
    public function __construct($config = [])
    {
        $this->config = $config;
    }

    /**
     * Create a fake image.
     *
     * @param string $size
     * @param string $text
     * @return gd resource
     */
    public function create($width = 150, $height = 150, $text = null)
    {
        // Create the image
        $image = imagecreatetruecolor($width, $height);

        // Apply the background color
        $backgroundcolor = imagecolorallocatealpha(
            $image,
            $this->config['colors']['background']['red'],
            $this->config['colors']['background']['green'],
            $this->config['colors']['background']['blue'],
            $this->config['colors']['background']['alpha']
        );
        imagesavealpha($image, true);
        imagefill($image, 0, 0, $backgroundcolor);

        // Image text Color
        $textcolor = imagecolorallocatealpha(
            $image,
            $this->config['colors']['text']['red'],
            $this->config['colors']['text']['green'],
            $this->config['colors']['text']['blue'],
            $this->config['colors']['text']['alpha']
        );

        // Image overlay text
        $overlay = $text !== null ? $text : $width . ' x ' . $height;

        // Prefer the usage of true type fonts for larger font size
        if (function_exists('imagettftext')) {
            return $this->createFromTrueType($image, $width, $height, $textcolor, $overlay);
        } else {
            return $this->createFromString($image, $width, $height, $textcolor, $overlay);
        }
    }

    /**
     * Create an image using imagettftext.
     *
     * @param gd resource $image
     * @param int $width
     * @param int $height
     * @param int $textcolor
     * @param string $overlay
     * @return gd resource
     */
    public function createFromTrueType($image, $width, $height, $textcolor, $overlay)
    {
        // Localize the font size since we will be changing it to auto fit
        $fontsize = $this->config['font_size'];

        // Calculate the font size based on the image size
        $box = imagettfbbox($fontsize, 0, $this->config['font'], $overlay);

        // Decrease the default font size until it fits
        while (((($width - ($box[2] - $box[0])) < 10) || (($height - ($box[1] - $box[7])) < 10)) && ($fontsize > 1)) {
            $fontsize--;
            $box = imagettfbbox($fontsize, 0, $this->config['font'], $overlay);
        }

        // Once it fits scale the font size down so we have some padding
        if($fontsize < $this->config['font_size']) {
            $fontsize = $fontsize * .60;
            $box = imagettfbbox($fontsize, 0, $this->config['font'], $overlay);
        }

        imagettftext($image, $fontsize, 0, ($width / 2) - (($box[2] - $box[0]) / 2), ($height / 2) + (($box[1] - $box[7]) / 2), $textcolor, $this->config['font'], $overlay);

        return $image;
    }

    /**
     * Create an image using imagestring.
     *
     * @param gd resource $image
     * @param int $width
     * @param int $height
     * @param int $textcolor
     * @param string $overlay
     * @return gd resource
     */
    public function createFromString($image, $width, $height, $textcolor, $overlay)
    {
        // Get the positions to center the text
        $textwidth = strlen($overlay) * imagefontwidth($this->config['font_size']);
        $xpos = ($width - $textwidth)/2;
        $ypos = ($height- imagefontheight($this->config['font_size']))/2;

        imagestring($image, $this->config['font_size'], $xpos, $ypos, $overlay, $textcolor);

        return $image;
    }

    /**
     * Parse the size for the height and width.
     *
     * @param string $size
     * @return array
     */
    public function dimensions($size)
    {
        // Image size
        list($width, $height) = explode('x', $size);

        return [
            'width' => (int) $width,
            'height' => (int) $height,
        ];
    }

    /**
     * Block images that are to large.
     *
     * @param array $dimensions
     * @return boolean
     */
    public function reasonableSize($dimensions)
    {
        return $dimensions['width'] * $dimensions['height'] < $this->config['max_size'];
    }

    /**
     * Check if the request is from the same domain to prevent hotlinking images.
     *
     * @param string $host
     * @param string $referer
     * @return boolean
     */
    public function onSameHost($host, $referer)
    {
        $parsed_host = parse_url($host);
        $parsed_referer = parse_url($referer);

        if ($this->config['enable_hotlinking']) {
            return true;
        }

        return $parsed_referer['path'] === '' || isset($parsed_referer['host']) && $parsed_host['host'] === $parsed_referer['host'];
    }
}
