<?php 
namespace App\Controllers;

use App\Models\Image;
use App\Controllers\RequestValidator\Validators\Responses\UnableToSave;
use App\Controllers\RequestValidator\Validators\Responses\SuccessfulOperation;
class ImagesController {
    public function create(RequestValidator\RequestValidator $validator): void 
    {
        $requestValidation = $validator->validate();
        if($requestValidation !== true)  $this->respond(400,$requestValidation);
        else {
            $image = new Image();
            if($image->save()) {
                $response = new SuccessfulOperation();
                $this->respond(200,$response->toJson());
            }
            else {
                $response = new UnableToSave();
                $this->respond(500, $response->toJson());
            }
        }
    }

    public function get() {
        echo "I'M in :)";
    }

    private function respond(int $code, string $message) {
        http_response_code($code);
        echo $message;
    }
} 

?>