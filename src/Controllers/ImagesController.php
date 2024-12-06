<?php 
namespace App\Controllers;

class ImagesController {

    public function create(array $body, Validators\IRequestValidator $validator): void {
        http_response_code(400);
        echo $validator->validate($body);
    }
} 

?>