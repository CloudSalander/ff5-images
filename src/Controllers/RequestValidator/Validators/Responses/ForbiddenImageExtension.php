<?php
namespace App\Controllers\RequestValidator\Validators\Responses;

class ForbiddenImageExtension extends Error {
    public function __construct() {
        $this->code = 7;
        $this->message = 'Wrong image format!(jpg,gif,png,webp allowed)';
    }
}