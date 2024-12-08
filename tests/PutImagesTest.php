
<?php

class PutImagesTest extends BaseTest
{
    private const TRANSFORMATION_OPTIONS = ['grayscale','invert','pixelate'];
    
    public function testPutNonExistingImage() {
        $this->clearImagesTable();
        $id = 1;
        $response = $this->client->put("images/{$id}",[
            'json' => [
                'effect' => self::TRANSFORMATION_OPTIONS[0],
                'title' => $this->getRandomString(self::RIGHT_TITLE_LENGTH)
            ]
        ]);

        $this->assertEquals(404, $response->getStatusCode());
        $data = $this->assertJSONResponse($response->getBody());
        $this->assertResponseContent($data,'No images found!',9);
    }


    public function testPutExistingImage() {
        $this->markTestSkipped('Sorry, unable to simulate update of an existing file for this testing. By now ;)');
        $this->insertImages(1);
        $id = 1;
        $response = $this->client->put("images/{$id}",[
            'json' => [
                'effect' => self::TRANSFORMATION_OPTIONS[0],
                'title' => $this->getRandomString(self::RIGHT_TITLE_LENGTH)
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $data = $this->assertJSONResponse($response->getBody());
        $this->validateGetImagesResponseStructure($data['data']);
    }

    public function testWrongEffect() {
        $this->clearImagesTable();
        $this->insertImages(1);
        $id = 1;
        $response = $this->client->put("images/{$id}",[
            'json' => [
                'effect' => 'rotate',
                'title' => $this->getRandomString(self::RIGHT_TITLE_LENGTH)
            ]
        ]);
        
        $this->assertEquals(400, $response->getStatusCode());
        $data = $this->assertJSONResponse($response->getBody());
        $this->assertResponseContent($data,'Please,input valid effect(grayscale,invert,pixelate)',10);
    }

    public function testCantPutImagesWithWrongTitle(): void
    {   
        $this->clearImagesTable();
        $this->insertImages(1);
        $id = 1;
        $response = $this->client->put("images/{$id}",[
            'json' => [
                'effect' => self::TRANSFORMATION_OPTIONS[0],
                'title' => $this->generateWrongTitle(self::RIGHT_TITLE_LENGTH)
            ]
        ]);
        $this->assertEquals(400, $response->getStatusCode());
        
        $data = $this->assertJSONResponse($response->getBody());
        
        $this->assertResponseContent($data,'Title has forbbidden chars! Please, just use letter,numbers,-,_,!,?',4);
    }

    public function testCantPutImagesWithLargeTitle(): void
    {   
        $this->clearImagesTable();
        $this->insertImages(1);
        $id = 1;
        $response = $this->client->put("images/{$id}",[
            'json' => [
                'effect' => self::TRANSFORMATION_OPTIONS[0],
                'title' => $this->getRandomString(self::MAX_TITLE_LENGTH)
            ]
        ]);
        $this->assertEquals(400, $response->getStatusCode());
        
        $data = $this->assertJSONResponse($response->getBody());
        
        $this->assertResponseContent($data,'Title is too large!',3);
    }

    


}