<?php
namespace App\Controllers\RequestValidators;

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