<?php

namespace App\Models\ImageTransformations;
use Intervention\Image\ImageManager;


class ImagePixelation implements iTransformImage {

    public function __construct(string $imagePath) {
        $this->transform($imagePath);
    }

    public function transform(string $imagePath) {
       $manager = new ImageManager(['driver' => 'gd']);
       $image = $manager->make($imagePath);

       $pixelSize = mt_rand(1, 20);     //Random values just for showing that this works
       $image->pixelate($pixelSize);
       $image->save($imagePath);
    }
}