<?php
namespace App\Controllers\RequestValidator\Validators\Responses;

class LargeTitle extends Error {
    public function __construct() {
        $this->code = 3;
        $this->message = 'Title is too large!';
    }
}