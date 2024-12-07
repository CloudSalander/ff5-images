<?php
namespace App\Controllers\RequestValidator\Validators\Errors;

class SuccessfulOperation extends Error {
    public function __construct() {
        $this->code = 1;
        $this->message = 'Successful operation';
    }
}