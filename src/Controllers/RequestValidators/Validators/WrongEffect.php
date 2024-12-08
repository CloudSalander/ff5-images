<?php 
namespace App\Controllers\RequestValidators\Validators;

class WrongEffect implements iValidator {
    private const ALLOWED_EFFECTS = ['grayscale','invert','pixelate'];

    public function validate(): bool|string {
        if(!$this->isValidEffect()) { 
            $error = new Errors\WrongEffect();
            return $error->toJson();
        }
        return true;
    }
    
    private function isValidEffect(): bool {
        $effect = $_POST['effect'];
        return in_array($effect,self::ALLOWED_EFFECTS);
    }
}