<?php
namespace App\Controllers\RequestValidator\Validators\Responses;

class SuccessfulOperation extends Error {
    public function __construct() {
        $this->code = 1;
        $this->message = 'Successful operation';
    }
}