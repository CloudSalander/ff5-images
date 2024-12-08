<?php
namespace App\Controllers\RequestValidators\Validators\Errors;

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