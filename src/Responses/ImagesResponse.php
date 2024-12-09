<?php
namespace App\Responses;

class ImagesResponse extends SuccessResponse {
    public function __construct(array $data = []) {
        $this->code = 1;
        $this->message = 'Successful operation';
        $this->data = $this->processImages($data);
    }
    private function processImages($data): array {
        foreach($data as $key =>$image) {
            $data[$key]['image'] = $this->getImageFormat($image['image']);
        }
        return $data;
    }
    private function getImageFormat(string $path): string {
        $explodedPath = explode(".",$path);
        $image = base64_encode(file_get_contents($path));
        return 'data:image/'.$explodedPath[1].';base64,' . $image;
    } 
}