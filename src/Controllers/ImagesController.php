<?php 
namespace App\Controllers;

class ImagesController {

    public function create(RequestValidator\RequestValidator $validator): void 
    {
        $requestValidation = $validator->validate();
        if($requestValidation !== true) {
            http_response_code(400); 
            echo $requestValidation;
        }
        else {
            http_response_code(200);
            //INSERT IMAGE
        }
    }
} 

?>