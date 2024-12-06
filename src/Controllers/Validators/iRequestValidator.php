<?php
namespace App\Controllers\Validators;

interface iRequestValidator {
    public function validate(array $request): bool|string;
}