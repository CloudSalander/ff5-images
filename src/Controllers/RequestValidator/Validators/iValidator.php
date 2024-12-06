<?php
namespace App\Controllers\RequestValidator\Validators;

interface iValidator {
    public function validate(): bool|string;
}