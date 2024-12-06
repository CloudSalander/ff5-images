<?php
namespace App\Controllers\Validators;

interface iRequestValidator {
    public function validate(): bool|string;
}