<?php
namespace App\Controllers\RequestValidators\Validators\Errors;

class WrongEffect extends Error {
    public function __construct() {
        $this->code = 10;
        $this->message = 'Please,input valid effect(grayscale,invert,pixelate)';
    }
}