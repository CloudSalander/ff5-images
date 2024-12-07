<?php
namespace App\Controllers\RequestValidator\Validators\Responses;

class NoImages extends Error {
    public function __construct() {
        $this->code = 9;
        $this->message = 'No images found!';
    }
}