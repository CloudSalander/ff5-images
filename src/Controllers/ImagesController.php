<?php 
namespace App\Controllers;

class ImagesController {

    public function create(RequestValidator\Validators\IValidator $validator): void {
        http_response_code(400);
        echo $validator->validate();
    }
} 

?>