<?php
namespace App\Controllers\RequestValidators\Validators\Errors;

class UnableToSave extends Error {
    public function __construct() {
        $this->code = 8;
        $this->message = 'Unable to save image';
    }
}