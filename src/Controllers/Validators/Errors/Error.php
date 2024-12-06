<?php

namespace App\Controllers\Validators\Errors;

abstract class Error {
    protected int $code;
    protected string $msg;

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