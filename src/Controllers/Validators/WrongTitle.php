<?php 
namespace App\Controllers\Validators;

class WrongTitle implements iRequestValidator {
    
    const ALLOWED_CHARS = '/^[a-zA-Z0-9-_!?]+$/';

    public function validate(array $request): bool|string {
        if(!preg_match('/^[a-zA-Z0-9-_!?]+$/', $request['title'])) { 
            $error = new Errors\WrongTitle();
            return $error->toJson();
        }
        return true;
    }
}