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
        $backgroundcolor = imagecolorallocatealpha(
            $image,
            $this->config['colors']['background']['red'],
            $this->config['colors']['background']['green'],
            $this->config['colors']['background']['blue'],
            $this->config['colors']['background']['alpha']

        );
        imagesavealpha($image, true);
        imagefill($image, 0, 0, $backgroundcolor);

        // Text that overlays on the image
        $overlay = $text !== null ? $text : $width . ' x ' . $height;

        // Overlay the text on the image
        $textwidth = strlen($overlay) * imagefontwidth($this->config['font_size']);
        $xpos = ($width - $textwidth)/2;
        $ypos = ($height- imagefontheight($this->config['font_size']))/2;
        $textcolor = imagecolorallocatealpha(
            $image,
            $this->config['colors']['text']['red'],
            $this->config['colors']['text']['green'],
            $this->config['colors']['text']['blue'],
            $this->config['colors']['text']['alpha']
        );

        // Prefer the usage of true type fonts for larger font size
        if (function_exists('imagettftext')) {
            imagettftext($image, $this->config['font_size'], 0, $xpos, $ypos, $textcolor, __DIR__.'/font/Roboto-Regular.ttf', $overlay);
        } else {
            imagestring($image, $this->config['font_size'], $xpos, $ypos, $overlay, $textcolor);
        }

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

        return $this->config['enable_hotlinking'] || $parsed_referer['path'] === '' || isset($parsed_referer['host']) && $parsed_host['host'] === $parsed_referer['host'];
    }
}
