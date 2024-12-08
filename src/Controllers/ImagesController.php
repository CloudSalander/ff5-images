<?php 
namespace App\Controllers;

use App\Models\Image;
use App\Controllers\RequestValidators\Validators\Errors\UnableToSave;
use App\Controllers\RequestValidators\Validators\Errors\NoImages;
use App\Responses\SuccessfulOperationResponse;
use App\Responses\ImagesResponse;
class ImagesController {

    private Image $imageModel;
    
    public function __construct() {
        $this->imageModel = new Image();
    }

    public function create(RequestValidators\RequestValidator $validator): void 
    {
        $requestValidation = $validator->validate();
        if($requestValidation !== true)  $this->respond(400,$requestValidation);
        else {
            $this->imageModel->setData();
            if($this->imageModel->save()) {
                $response = new SuccessfulOperationResponse();
                $this->respond(200,$response->toJson());
            }
            else {
                $response = new UnableToSave();
                $this->respond(500, $response->toJson());
            }
        }
    }

    public function get($id = null) {
        if(isset($id)) {
            $image = $this->imageModel->getImageById($id);
            $image !== false? $images[] = $image : $images = [];
        }
        else $images = $this->imageModel->getImages();
        if(count($images) === 0) {
            $response = new NoImages();
            $this->respond(404,$response->toJson());
        }
        else {
            $response = new ImagesResponse($images);
            $this->respond(200,$response->toJson());
        }
    }

    public function delete($id = null) {
        var_dump("I'm in!");
    }

    private function respond(int $code, string $message) {
        http_response_code($code);
        echo $message;
    }
} 

?>