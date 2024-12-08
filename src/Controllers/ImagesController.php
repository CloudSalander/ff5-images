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

    public function create(RequestValidators\RequestValidator $validator) 
    {
        $requestValidation = $validator->validate();
        if($requestValidation !== true)  return $this->respond(400,$requestValidation);
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

    public function get(int $id = null) {
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

    public function update(RequestValidators\RequestValidator $validator, int $id = null) {
        $this->setInputData();
        $requestValidation = $validator->validate();
        if($requestValidation !== true)  return $this->respond(400,$requestValidation);
        
        if(isset($id)) $result = $this->imageModel->updateImageById($id);
        
        if($result) {
            $response = new SuccessfulOperationResponse();
            $this->respond(200,$response->toJson());
        }
        else {
            $response = new NoImages();
            $this->respond(404,$response->toJson());
        }   
    }
    //Not the most elegant one, but effective :)
    private function setInputData() {
        $rawData = file_get_contents('php://input');
        $inputData = json_decode($rawData, true);
        
        if(isset($inputData['title'])) $_POST['title'] = $inputData['title'];
        else $_POST['title'] = '';

        if(isset($inputData['effect'])) $_POST['effect'] = $inputData['effect'];
        else $_POST['effect'] = '';
    }

    public function delete(int $id = null) {
        $result = false;
        if(isset($id)) $result = $this->imageModel->deleteImageById($id);
        
        if($result) {
            $response = new SuccessfulOperationResponse();
            $this->respond(200,$response->toJson());
        }
        else {
            $response = new NoImages();
            $this->respond(404,$response->toJson());
        }   

    }

    private function respond(int $code, string $message) {
        http_response_code($code);
        echo $message;
    }
} 

?>