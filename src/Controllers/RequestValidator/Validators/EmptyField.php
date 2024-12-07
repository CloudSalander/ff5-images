<?php 
namespace App\Controllers\RequestValidator\Validators;

class EmptyField implements iValidator {

    public function validate(): bool|string {
        if(!isset($_POST['title']) || $_POST['title'] == ''
            || !isset($_FILES['image'])  || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE){ 
                $error = new Errors\EmptyField();
                return $error->toJson();
        }
        return true;
    }
}