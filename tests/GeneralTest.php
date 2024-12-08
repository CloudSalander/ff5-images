<?php 

class GeneralTest extends BaseTest {
    
    public function testNotFound()
    {
        $wrong_uri_sample = 'images';
        $response = $this->client->post($wrong_uri_sample);
       
        $this->assertEquals(400, $response->getStatusCode());
    }
}
