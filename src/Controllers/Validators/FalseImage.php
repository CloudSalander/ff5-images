<?php 
namespace App\Controllers\Validators;

class FalseImage implements iRequestValidator {
    
    public function validate(array $request): bool|string {
        if(!$this->isValidImage()) { 
            $error = new Errors\FalseImage();
            return $error->toJson();
        }
        return true;
    }
    
    private function isValidImage(): bool {
        $filePath = $_FILES['image']['tmp_name'];
        if (file_exists($filePath)) {
            $imageInfo = getimagesize($filePath);
            if ($imageInfo) return true;
        } 
        return false;
    }
}