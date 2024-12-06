<?php

class PostImagesTest extends BaseTest
{
    private const MAX_TITLE_LENGTH = 160;
    private const RIGHT_TITLE_LENGTH = 16;
    private const SAMPLE_IMAGE_PATH = 'images/image1.jpg';
    
    public function testCantPostImagesWithoutTitleAndImage(): void
    {
        $response = $this->client->post('images');
        
        $this->assertEquals(400, $response->getStatusCode());
        
        $data = $this->assertJSONResponse($response->getBody());
        $this->assertResponseContent($data,'You have to include title and image',2);
    }

    public function testCantPostImagesWithLargeTitle(): void
    {   

        $response = $this->client->post('images',[
            "multipart" => [
                [
                    "name" => 'image',
                    "contents" => fopen(self::SAMPLE_IMAGE_PATH,'r'),
                ],
                [
                    "name" => "title", 
                    "contents"=> $this->getRandomString(self::MAX_TITLE_LENGTH)
                ]
            ]]);

        $this->assertEquals(400, $response->getStatusCode());
        
        $data = $this->assertJSONResponse($response->getBody());
        
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
        
        $data = $this->assertJSONResponse($response->getBody());
        
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
        
        $data = $this->assertJSONResponse($response->getBody());
        
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
        
        $data = $this->assertJSONResponse($response->getBody());
        
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
        
        $data = $this->assertJSONResponse($response->getBody());
        
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
        
        $data = $this->assertJSONResponse($response->getBody());
        
        $this->assertResponseContent($data,'Image succesfully uploaded!',1);
    }

}
