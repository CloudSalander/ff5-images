<?php 
namespace App\Controllers\Validator\Validators;

class WrongTitle implements iValidator {
    
    const ALLOWED_CHARS = '/^[a-zA-Z0-9-_!?]+$/';

    public function validate(): bool|string {
        if(!preg_match('/^[a-zA-Z0-9-_!?]+$/', $_POST['title'])) { 
            $error = new Errors\WrongTitle();
            return $error->toJson();
        }
        return true;
    }
}