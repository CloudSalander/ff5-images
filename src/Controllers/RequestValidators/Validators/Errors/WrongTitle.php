<?php
namespace App\Controllers\RequestValidators\Validators\Errors;

class WrongTitle extends Error {
    public function __construct() {
        $this->code = 4;
        $this->message = 'Title has forbbidden chars! Please, just use letter,numbers,-,_,!,?';
    }
}