<?php
namespace App\Controllers\RequestValidators\Validators;

interface iValidator {
    public function validate(): bool|string;
}