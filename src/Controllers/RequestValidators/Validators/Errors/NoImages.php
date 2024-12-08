<?php
namespace App\Controllers\RequestValidators\Validators\Errors;

class NoImages extends Error {
    public function __construct() {
        $this->code = 9;
        $this->message = 'No images found!';
    }
}