<?php 

use GuzzleHttp\Exception\ClientException;

class GeneralTest extends BaseTest {
    
    public function test404NotFound()
    {
        $wrong_uri_sample = 'image';
        $this->client->post($wrong_uri_sample);
       
        $response = $e->getResponse();
        $this->assertEquals(404, $response->getStatusCode());

        $data = assertJSONResponse($response);
        
        $this->assertResponseContent($data,'Endpoint Not found',-1);
    }
}
