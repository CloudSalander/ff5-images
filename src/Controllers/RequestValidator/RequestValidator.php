<?php
namespace App\Controllers\RequestValidator;

abstract class RequestValidator {

    protected array $validators;

    public function validate(): bool | string {
        foreach($this->validators as $validator) {
            $validationResult = $validator->validate();
            if($validationResult !== true) return $validationResult;
        }
        return true;
    }
}
?>