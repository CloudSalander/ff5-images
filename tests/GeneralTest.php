<?php 

class GeneralTest extends BaseTest {
    
    public function test404NotFound()
    {
        $wrong_uri_sample = 'images';
        $response = $this->client->post($wrong_uri_sample);
       
        $this->assertEquals(404, $response->getStatusCode());
    }
}
