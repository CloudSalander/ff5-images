<?php 
namespace App\Controllers\RequestValidator\Validators;

class ForbiddenImageExtension implements iValidator {
    
    private const ALLOWED_EXTENSIONS = ['jpg','jpeg','gif','png','webp'];

    public function validate(): bool|string {
        if(!$this->isValidExtension()) { 
            $error = new Responses\ForbiddenImageExtension();
            return $error->toJson();
        }
        return true;
    }
    
    private function isValidExtension(): bool {
        $fileExtension = explode("/",$_FILES['image']['type']);
        $fileExtension = $fileExtension[1];
        return in_array($fileExtension,self::ALLOWED_EXTENSIONS);
    }
}