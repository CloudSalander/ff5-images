<?php
namespace App\Responses;

class SuccessfulOperationResponse extends SuccessResponse {
    public function __construct($data = []) {
        $this->code = 1;
        $this->message = 'Successful operation';
        $this->data = $data;
    }
}