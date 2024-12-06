<?php
namespace App\Controllers\Validators\Errors;

class FalseImage extends Error {
    public function __construct() {
        $this->code = 5;
        $this->message = 'This is not an image';
    }
}