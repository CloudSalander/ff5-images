<?php 
namespace App\Controllers\Validators;

class EmptyField implements iRequestValidator {
    public function validate(): bool|string {
        if(!isset($_POST['title']) || $_POST['title'] == ''
            || !isset($_FILES['image'])  || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE){ 
                $error = new Errors\EmptyField();
                return $error->toJson();
        }
        return true;
    }
}