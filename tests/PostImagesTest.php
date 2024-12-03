<?php

class PostImagesTest extends BaseTest
{
    const MAX_TITLE_LENGTH = 151;
    const RIGHT_TITLE_LENGTH = 16;
    const SAMPLE_IMAGE_PATH = 'images/image1.jpg';
    const FALSE_IMAGE_PATH = 'images/false_image.jpg';
    const LARGE_IMAGE_PATH = 'images/large_image.jpg';
    const WRONG_FORMAT_IMAGE_PATH = 'images/wrong-format-image.avif';
    
    public function testCantPostImagesWhithoutTitleAndImage(): void
    {
        $response = $this->client->post('images');
        
        $this->assertEquals(400, $response->getStatusCode());
        
        $body = (string) $response->getBody();
        $this->assertJson($body);
        $data = json_decode($body, true);
        
        $this->assertArrayHasKey('message', $data);
        $this->assertEquals('You have to include title and image', $data['message']);
        
        $this->assertArrayHasKey('code', $data);
        $this->assertEquals(2, $data['code']);
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
        
        $body = (string) $response->getBody();
        $this->assertJson($body);
        $data = json_decode($body, true);
        
        $this->assertArrayHasKey('message', $data);
        $this->assertEquals('Title is too large!', $data['message']);
        
        $this->assertArrayHasKey('code', $data);
        $this->assertEquals(3, $data['code']);
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
        
        $body = (string) $response->getBody();
        $this->assertJson($body);
        $data = json_decode($body, true);
        
        $this->assertArrayHasKey('message', $data);
        $this->assertEquals('Title has forbbidden chars! Please, just use letter,numbers,-,_,!,?', $data['message']);
        
        $this->assertArrayHasKey('code', $data);
        $this->assertEquals(4, $data['code']);
    }

    public function testCantPostFalseImage(): void {
        $response = $this->client->post('images',[
            "json" => [
                "title" => $this->getRandomString(self::MAX_TITLE_LENGTH)
            ],
            "multipart" => [
                "name" => 'image',
                "contents" => fopen(self::FALSE_IMAGE_PATH,'r'),
            ]
        ]);

        $this->assertEquals(400, $response->getStatusCode());
        
        $body = (string) $response->getBody();
        $this->assertJson($body);
        $data = json_decode($body, true);
        
        $this->assertArrayHasKey('message', $data);
        $this->assertEquals('This is not an image ;)', $data['message']);
        
        $this->assertArrayHasKey('code', $data);
        $this->assertEquals(6, $data['code']);
    }

    public function testCantPostLargeImage(): void {
        $response = $this->client->post('images',[
            "json" => [
                "title" => $this->getRandomString(self::MAX_TITLE_LENGTH)
            ],
            "multipart" => [
                "name" => 'image',
                "contents" => fopen(self::LARGE_IMAGE_PATH,'r'),
            ]
        ]);

        $this->assertEquals(400, $response->getStatusCode());
        
        $body = (string) $response->getBody();
        $this->assertJson($body);
        $data = json_decode($body, true);
        
        $this->assertArrayHasKey('message', $data);
        $this->assertEquals('Image too large!(5 MB max!)', $data['message']);
        
        $this->assertArrayHasKey('code', $data);
        $this->assertEquals(7, $data['code']);
    }

    public function testCantPostForbiddenImageExtension(): void {
        $response = $this->client->post('images',[
            "json" => [
                "title" => $this->getRandomString(self::MAX_TITLE_LENGTH)
            ],
            "multipart" => [
                "name" => 'image',
                "contents" => fopen(self::WRONG_FORMAT_IMAGE_PATH,'r'),
            ]
        ]);

        $this->assertEquals(400, $response->getStatusCode());
        
        $body = (string) $response->getBody();
        $this->assertJson($body);
        $data = json_decode($body, true);
        
        $this->assertArrayHasKey('message', $data);
        $this->assertEquals('Wrong image format!(jpg,gif,png,webp allowed)', $data['message']);
        
        $this->assertArrayHasKey('code', $data);
        $this->assertEquals(8, $data['code']);
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
        
        $body = (string) $response->getBody();
        $this->assertJson($body);
        $data = json_decode($body, true);
        
        $this->assertArrayHasKey('message', $data);
        $this->assertEquals('Image succesfully uploaded!', $data['message']);
        
        $this->assertArrayHasKey('code', $data);
        $this->assertEquals(1, $data['code']);
    }

    private function getRandomString(int $n): string {
        return bin2hex(random_bytes($n / 2));
    }

    function generateWrongTitle(int $length = 16): string {
        // Define un conjunto de caracteres permitidos
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
