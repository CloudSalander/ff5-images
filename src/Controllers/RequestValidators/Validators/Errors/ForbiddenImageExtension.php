<?php
namespace App\Controllers\RequestValidators\Validators\Errors;

class ForbiddenImageExtension extends Error {
    public function __construct() {
        $this->code = 7;
        $this->message = 'Wrong image format!(jpg,gif,png,webp allowed)';
    }
}