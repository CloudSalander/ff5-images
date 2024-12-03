<?php

class PostImagesTest extends BaseTest
{
    private const MAX_TITLE_LENGTH = 151;
    private const RIGHT_TITLE_LENGTH = 16;
    private const SAMPLE_IMAGE_PATH = 'images/image1.jpg';
    
    public function testCantPostImagesWhithoutTitleAndImage(): void
    {
        $response = $this->client->post('images');
        
        $this->assertEquals(400, $response->getStatusCode());
        
        $data = assertJSONResponse($client);
        
        $this->assertResponseContent($data,'You have to include title and image',2);
    }

    public function testCantPostImagesWithLargeTitle(): void
    {   
        $response = $this->client->post('images',[
            "json" => [
                "title" => $this->getRandomString(self::MAX_TITLE_LENGTH)
            ],
            "multipart" => [
                "name" => 'image',
                "contents" => fopen(self::SAMPLE_IMAGE_PATH,'r'),
            ]
        ]);

        $this->assertEquals(400, $response->getStatusCode());
        
        $data = assertJSONResponse($client);
        
        $this->assertResponseContent($data,'Title is too large!',3);
    }

    public function testCantPostImagesWithWrongTitle(): void
    {   
        $response = $this->client->post('images',[
            "json" => [
                "title" => $this->generateWrongTitle(self:: RIGHT_TITLE_LENGTH)
            ],
            "multipart" => [
                "name" => 'image',
                "contents" => fopen(self::SAMPLE_IMAGE_PATH,'r'),
            ]
        ]);

        $this->assertEquals(400, $response->getStatusCode());
        
        $data = assertJSONResponse($client);
        
        $this->assertResponseContent($data,'Title has forbbidden chars! Please, just use letter,numbers,-,_,!,?',4);
    }

    public function testCantPostFalseImage(): void {

        $falseImagePath = 'images/false_image.jpg';

        $response = $this->client->post('images',[
            "json" => [
                "title" => $this->getRandomString(self::MAX_TITLE_LENGTH)
            ],
            "multipart" => [
                "name" => 'image',
                "contents" => fopen($falseImagePath,'r'),
            ]
        ]);

        $this->assertEquals(400, $response->getStatusCode());
        
        $data = assertJSONResponse($client);
        
        $this->assertResponseContent($data,'This is not an image',5);

    }

    public function testCantPostLargeImage(): void {

        $largeImagePath = 'images/large_image.jpg';

        $response = $this->client->post('images',[
            "json" => [
                "title" => $this->getRandomString(self::MAX_TITLE_LENGTH)
            ],
            "multipart" => [
                "name" => 'image',
                "contents" => fopen($largeImagePath,'r'),
            ]
        ]);

        $this->assertEquals(400, $response->getStatusCode());
        
        $data = assertJSONResponse($client);
        
        $this->assertResponseContent($data,'Image too large!(5 MB max!)',6);
    }

    public function testCantPostForbiddenImageExtension(): void {

        $wrongImagePath = 'images/wrong-format-image.avif';
        
        $response = $this->client->post('images',[
            "json" => [
                "title" => $this->getRandomString(self::MAX_TITLE_LENGTH)
            ],
            "multipart" => [
                "name" => 'image',
                "contents" => fopen($wrongImagePath,'r'),
            ]
        ]);

        $this->assertEquals(400, $response->getStatusCode());
        
        $data = assertJSONResponse($client);
        
        $this->assertResponseContent($data,'Wrong image format!(jpg,gif,png,webp allowed)',7);
    }

    public function testCanPostImage(): void {
        $response = $this->client->post('images',[
            "json" => [
                "title" => $this->getRandomString(self::RIGHT_TITLE_LENGTH)
            ],
            "multipart" => [
                "name" => 'image',
                "contents" => fopen(self::SAMPLE_IMAGE_PATH,'r'),
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        
        $data = assertJSONResponse($client);
        
        $this->assertResponseContent($data,'Image succesfully uploaded!',1);
    }

    private function assertJSONResponse(Response $response): mixed {
        $body = (string) $response->getBody();
        $this->assertJson($body);
        return json_decode($body, true);
    }

    private function assertResponseContent(mixed $data, string $message, string $code): void {
        $this->assertArrayHasKey('message', $data);
        $this->assertEquals($message, $data['message']);
        
        $this->assertArrayHasKey('code', $data);
        $this->assertEquals($code, $data['code']);
    }

    private function getRandomString(int $n): string {
        return bin2hex(random_bytes($n / 2));
    }

    function generateWrongTitle(int $length = 16): string {
        $allowedCharacters = '!@#$%^&*()+=~`;:<>,./{}[]|';
        $allowedLength = strlen($allowedCharacters);
    
        $result = '';
    
        for ($i = 0; $i < $length; $i++) {
            $index = random_int(0, $allowedLength - 1); 
            $result .= $allowedCharacters[$index];
        }
        return $result;
    }
}
