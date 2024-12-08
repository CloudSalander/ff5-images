<?php 
namespace App\Controllers\RequestValidators\Validators;

class LargeTitle implements iValidator {
    
    private const LONG_TEXT_LENGTH = 150;

    public function validate(): bool|string {
        if(strlen($_POST['title']) > self::LONG_TEXT_LENGTH) { 
            $error = new Errors\LargeTitle();
            return $error->toJson();
        }
        return true;
    }
}