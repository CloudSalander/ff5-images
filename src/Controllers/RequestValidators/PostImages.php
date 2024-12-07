<?php
namespace App\Controllers\RequestValidators;


class PostImages extends RequestValidator {
    public function __construct() {
        $this->validators = [
            new Validators\EmptyField(),
            new Validators\LargeTitle(),
            new Validators\WrongTitle(),
            new Validators\FalseImage(),
            new Validators\LargeImage(),
            new Validators\ForbiddenImageExtension()
        ];
    }
}