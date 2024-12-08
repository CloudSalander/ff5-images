<?php

class PostImagesTest extends BaseTest
{
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
            "multipart" => [
                [
                    "name" => 'image',
                    "contents" => fopen(self::SAMPLE_IMAGE_PATH,'r'),
                ],
                [
                    "name" => "title", 
                    "contents"=> $this->generateWrongTitle(self::RIGHT_TITLE_LENGTH)
                ]
            ]]);

        $this->assertEquals(400, $response->getStatusCode());
        
        $data = $this->assertJSONResponse($response->getBody());
        
        $this->assertResponseContent($data,'Title has forbbidden chars! Please, just use letter,numbers,-,_,!,?',4);
    }

    public function testCantPostFalseImage(): void 
    {

        $falseImagePath = __DIR__.'/images/false_image.jpg';

        $response = $this->client->post('images',[
            "multipart" => [
                [
                    "name" => 'image',
                    "contents" => fopen($falseImagePath,'r'),
                ],
                [
                    "name" => "title",
                    "contents" => $this->getRandomString(self::RIGHT_TITLE_LENGTH)
                ]
            ]]);

        $this->assertEquals(400, $response->getStatusCode());
        
        $data = $this->assertJSONResponse($response->getBody());
        
        $this->assertResponseContent($data,'This is not an image',5);

    }

    public function testCantPostLargeImage(): void 
    {

        $largeImagePath = __DIR__.'/images/large_image.jpg';

        $response = $this->client->post('images',[
            "multipart" => [
                [
                    "name" => 'image',
                    "contents" => fopen($largeImagePath,'r'),
                ],
                [
                    "name" => "title",
                    "contents" => $this->getRandomString(self::RIGHT_TITLE_LENGTH)
                ]
            ]]);

        $this->assertEquals(400, $response->getStatusCode());
        
        $data = $this->assertJSONResponse($response->getBody());
        
        $this->assertResponseContent($data,'Image too large!(5 MB max!)',6);
    }

    public function testCantPostForbiddenImageExtension(): void 
    {

        $wrongImagePath =  __DIR__.'/images/wrong-format-image.avif';
        
        $response = $this->client->post('images',[
            "multipart" => [
                [
                    "name" => 'image',
                    "contents" => fopen($wrongImagePath,'r'),
                ],
                [
                    "name" => "title",
                    "contents" => $this->getRandomString(self::RIGHT_TITLE_LENGTH)
                ]
            ]]);


        $this->assertEquals(400, $response->getStatusCode());
        
        $data = $this->assertJSONResponse($response->getBody());
        
        $this->assertResponseContent($data,'Wrong image format!(jpg,gif,png,webp allowed)',7);
    }

    public function testCanPostImage(): void 
    {
        $response = $this->client->post('images',[
            "multipart" => [
                [
                    "name" => 'image',
                    "contents" => fopen(self::SAMPLE_IMAGE_PATH,'r'),
                ],
                [
                    "name" => 'title',
                    "contents" => $this->getRandomString(self::RIGHT_TITLE_LENGTH),
                ]
            ]]);

        $this->assertEquals(200, $response->getStatusCode());
        
        $data = $this->assertJSONResponse($response->getBody());
        
        $this->assertResponseContent($data,'Successful operation',1);
        $this->clearImagesTable();
    }

}
