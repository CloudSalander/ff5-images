<?php 
namespace App\Controllers\Validators;

class LargeImage implements iRequestValidator {
    
    private const MAX_SIZE_MB = 5;
    private const BYTES_IN_MB = 1048576;
    
    public function validate(): bool|string {
        if(!$this->isLargeImage()) { 
            $error = new Errors\LargeImage();
            return $error->toJson();
        }
        return true;
    }

    private function isLargeImage(): bool {
        $filePath = $_FILES['image']['tmp_name'];
        if (file_exists($filePath)) {
            $imageSizeMB =  filesize($filePath) / self::BYTES_IN_MB;
            if($imageSizeMB > self::MAX_SIZE_MB) return false;
        }
        return true;
    }
}