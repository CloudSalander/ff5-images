<?php

class GetImagesTest extends BaseTest
{
    public function TestNoImagesRegistered(): void
    {
        $this->clearImagesTable();
        $response = $this->client->get('images');
        $this->assertEquals(404, $response->getStatusCode());

        $data = $this->assertJSONResponse($response->getBody());
        $this->assertResponseContent($data,'No images found!',9);
    }

    public function testGetImagesReturnsCorrectStructure(): void {
        $this->insertImages(3);
        $response = $this->client->get('images');

        $this->assertEquals(200, $response->getStatusCode());
        $data = $this->assertJSONResponse($response->getBody());
        
        $this->validateGetImagesResponseStructure($data['data']);
    }

    public function testGetNonExistingImage() {
        $this->clearImagesTable();
        $id = 1;
        $response = $this->client->get("images/{$id}");
        
        $this->assertEquals(404, $response->getStatusCode());
        $data = $this->assertJSONResponse($response->getBody());
        $this->assertResponseContent($data,'No images found!',9);
    }

    public function testGetExistingImage() {
        $this->insertImages(1);
        $id = 1;
        $response = $this->client->get("images/{$id}"); 
        
        $this->assertEquals(200, $response->getStatusCode());
        $data = $this->assertJSONResponse($response->getBody());
        $this->validateGetImagesResponseStructure($data['data']);
    }

    private function validateGetImagesResponseStructure(array $data) {
        $this->assertIsArray($data);
        $this->assertGreaterThan(0, count($data));

        foreach ($data as $image) {
            $this->assertArrayHasKey('title', $image);
            $this->assertArrayHasKey('image', $image);
            $this->assertIsString($image['title']);

            $this->assertIsString($image['image']);
            $this->assertMatchesRegularExpression('/^data:image\/(jpeg|png|gif|jpg|webp);base64,/', $image['image']);
        }
        $this->clearImagesTable();
    }
}