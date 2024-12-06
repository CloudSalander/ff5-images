<?php
namespace App\Controllers\Validators\Errors;

class LargeImage extends Error {
    public function __construct() {
        $this->code = 6;
        $this->message = 'Image too large!(5 MB max!)';
    }
}