<?php
namespace App\Controllers\RequestValidators;


class PutImages extends RequestValidator {
    public function __construct() {
        $this->validators = [
            new Validators\LargeTitle(),
            new Validators\WrongTitle(),
            new Validators\WrongEffect()
        ];
    }
}