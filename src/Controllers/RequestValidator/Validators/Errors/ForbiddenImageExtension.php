<?php
namespace App\Controllers\RequestValidator\Validators\Errors;

class ForbiddenImageExtension extends Error {
    public function __construct() {
        $this->code = 7;
        $this->message = 'Wrong image format!(jpg,gif,png,webp allowed)';
    }
}