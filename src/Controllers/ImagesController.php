<?php 
namespace App\Controllers;

class ImagesController {

    public function create(Validators\IRequestValidator $validator): void {
        http_response_code(400);
        echo $validator->validate();
    }
} 

?>