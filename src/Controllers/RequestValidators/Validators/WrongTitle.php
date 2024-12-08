<?php 
namespace App\Controllers\RequestValidators\Validators;

class WrongTitle implements iValidator {
    
    const ALLOWED_CHARS = '/^[a-zA-Z0-9-_!?]*$/';

    public function validate(): bool|string {
        if(!preg_match(self::ALLOWED_CHARS, $_POST['title'])) { 
            $error = new Errors\WrongTitle();
            return $error->toJson();
        }
        return true;
    }
}