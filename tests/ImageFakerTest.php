<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Waynestate\ImageFaker\ImageFaker;

class ImageFakerTest extends TestCase
{
    public function setUp()
    {
        $config = include(__DIR__.'/../config/image-faker.php');

        $this->image = new ImageFaker($config);
    }

    /**
     * @covers Styleguide\Repositories\FakeImageRepository::dimensions
     * @test
     */
    public function dimensions_should_return_height_and_width()
    {
        $expected = [
            'width' => 100,
            'height' => 50,
        ];

        $actual = $this->image->dimensions($expected['width'].'x'.$expected['height']);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers Styleguide\Repositories\FakeImageRepository::reasonableSize
     * @test
     */
    public function image_should_be_reasonable_size()
    {
        $reasonable = $this->image->reasonableSize([
            'width' => 100,
            'height' => 50,
        ]);

        $notReasonable = $this->image->reasonableSize([
            'width' => 5000,
            'height' => 4000,
        ]);

        $this->assertTrue($reasonable);
        $this->assertFalse($notReasonable);
    }

    /**
    * @covers Styleguide\Repositories\FakeImageRepository::create
    * @test
    */
    public function creating_image_should_have_proper_dimensions()
    {
        $width = 100;
        $height = 50;

        $image = $this->image->create($width, $height);

        $this->assertEquals($width, imagesx($image));
        $this->assertEquals($height, imagesy($image));
    }

    /**
    * @covers Styleguide\Repositories\FakeImageRepository::onSameHost
    * @test
    */
    public function allow_images_servered_on_same_host()
    {
        // Same domains
        $allow = $this->image->onSameHost('https://base.wayne.edu/', 'https://base.wayne.edu/page/');
        $this->assertTrue($allow);

        // Unknown referer (when viewing the image directly)
        $allow = $this->image->onSameHost('https://base.wayne.edu/', '');
        $this->assertTrue($allow);

        // Different domain disallowing hotlinking
        $this->image->config['enable_hotlinking'] = false;
        $allow = $this->image->onSameHost('https://base.wayne.edu/', 'https://other.wayne.edu/');
        $this->assertFalse($allow);

        // Different domain but allow hotlinking
        $this->image->config['enable_hotlinking'] = true;
        $allow = $this->image->onSameHost('https://base.wayne.edu/', 'https://other.wayne.edu/');
        $this->assertTrue($allow);
    }
}
