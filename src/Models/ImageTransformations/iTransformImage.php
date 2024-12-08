<?php

namespace App\Models\ImageTransformations;

interface iTransformImage {
    public function transform(string $imagePath);
}

?>