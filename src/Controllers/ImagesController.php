<?php 
namespace App\Controllers;

use App\Models\Image;
use App\Controllers\RequestValidator\Validators\Responses\UnableToSave;
use App\Controllers\RequestValidator\Validators\Responses\SuccessfulOperation;
use App\Controllers\RequestValidator\Validators\Responses\NoImages;
class ImagesController {

    private Image $imageModel;
    
    public function __construct() {
        $this->imageModel = new Image();
    }

    public function create(RequestValidator\RequestValidator $validator): void 
    {
        $requestValidation = $validator->validate();
        if($requestValidation !== true)  $this->respond(400,$requestValidation);
        else {
            $this->imageModel->setData();
            if($this->imageModel->save()) {
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
        $images = $this->imageModel->getImages();
        if(count($images) === 0) {
            $response = new NoImages();
            $this->respond(204,$response->toJson());
        }
        else {
            //return array of images
        }
    }

    private function respond(int $code, string $message) {
        http_response_code($code);
        echo $message;
    }
} 

?>