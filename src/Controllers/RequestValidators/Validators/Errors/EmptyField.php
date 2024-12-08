<?php
namespace App\Controllers\RequestValidators\Validators\Errors;

class EmptyField extends Error {
    public function __construct() {
        $this->code = 2;
        $this->message = 'You have to include title and image';
    }
}