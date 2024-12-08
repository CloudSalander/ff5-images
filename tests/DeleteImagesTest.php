<?php

class DeleteImagesTest extends BaseTest
{
    public function testDeleteNonExistingImage() {
        $this->clearImagesTable();
        $id = 1;
        $response = $this->client->delete("images/{$id}");
        
        $this->assertEquals(404, $response->getStatusCode());
        $data = $this->assertJSONResponse($response->getBody());
        $this->assertResponseContent($data,'No images found!',9);
    }

    public function testDeleteExistingImage() {
        $this->markTestSkipped('Sorry, unable to simulate creation and deletion of file for this testing. By now ;)');
        $this->clearImagesTable();
        $this->insertImages(1);
        $id = 1;
        $response = $this->client->delete("images/{$id}"); 
        
        $this->assertEquals(200, $response->getStatusCode());
        $data = $this->assertJSONResponse($response->getBody());
        $this->assertResponseContent($data,'Successful operation',1);
    }
}