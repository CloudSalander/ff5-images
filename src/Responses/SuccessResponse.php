<?php
namespace App\Responses;

abstract class SuccessResponse  {
    protected int $code;
    protected string $message;
    protected array $data;

    public function toArray() {
        return [
            'message' => $this->message,
            'code' => $this->code,
            'data' => $this->data
        ];
    }

    public function toJson() {
        return json_encode($this->toArray());
    }
}