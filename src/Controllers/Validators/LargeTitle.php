<?php 
namespace App\Controllers\Validators;

class LargeTitle implements iRequestValidator {
    
    const LONG_TEXT_LENGTH = 150;

    public function validate(array $request): bool|string {
        if(strlen($request['title']) > self::LONG_TEXT_LENGTH) { 
            $error = new Errors\LargeTitle();
            return $error->toJson();
        }
        return true;
    }
}