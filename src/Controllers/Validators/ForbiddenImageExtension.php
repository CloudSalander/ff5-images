<?php 
namespace App\Controllers\Validators;

class ForbiddenImageExtension implements iRequestValidator {
    
    private const ALLOWED_EXTENSIONS = ['jpg','jpeg','gif','png','webp'];

    public function validate(array $request): bool|string {
        if(!$this->isValidExtension()) { 
            $error = new Errors\ForbiddenImageExtension();
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