<?php
namespace App\Controllers\RequestValidator\Validators\Responses;

class UnableToSave extends Error {
    public function __construct() {
        $this->code = 8;
        $this->message = 'Unable to save image';
    }
}