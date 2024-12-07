<?php

namespace App\Controllers\RequestValidator\Validators\Responses;

abstract class Error {
    protected int $code;
    protected string $message;

    public function toArray() {
        return [
            'message' => $this->message,
            'code' => $this->code,
        ];
    }

    public function toJson() {
        return json_encode($this->toArray());
    }
}
?>