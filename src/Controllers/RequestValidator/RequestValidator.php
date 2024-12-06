<?php
namespace App\Controllers\Validator;

abstract class RequestValidator {

    private array $validators;

    public function validate(): bool | array {
        foreach($this->validators as $validator) {
            $validationResult = $validator->validate();
            if($validationResult !== true) return $validationResult;
        }
    }
}
?>