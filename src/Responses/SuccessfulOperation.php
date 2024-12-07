<?php
namespace App\Responses;

class SuccessfulOperation extends SuccessResponse {
    public function __construct() {
        $this->code = 1;
        $this->message = 'Successful operation';
        $this->data = [];
    }
}