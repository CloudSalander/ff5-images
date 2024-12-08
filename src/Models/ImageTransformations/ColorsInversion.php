<?php

namespace App\Models\ImageTransformations;
use Intervention\Image\ImageManager;


class ColorsInversion implements iTransformImage {

    public function __construct(string $imagePath) {
        $this->transform($imagePath);
    }

    public function transform(string $imagePath) {
       $manager = new ImageManager(['driver' => 'gd']);
       $image = $manager->make($imagePath);
       $image->invert();
       $image->save($imagePath);
    }
}