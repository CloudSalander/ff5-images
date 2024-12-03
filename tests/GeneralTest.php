<?php 

use GuzzleHttp\Exception\ClientException;

class GeneralTest extends BaseTest {
    
    public function test404NotFound()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessageMatches('/404 Not Found/');

        try {
            $this->client->post('image');
        } catch (ClientException $e) {
  
            $response = $e->getResponse();
            $this->assertEquals(404, $response->getStatusCode());

            $body = (string) $response->getBody();
            $this->assertJson($body);
            $data = json_decode($body, true);
            $this->assertArrayHasKey('message', $data);
            $this->assertEquals('Endpoint not found', $data['message']);

            $this->assertArrayHasKey('code', $data);
            $this->assertEquals(1, $data['code']);

            throw $e;
        }
    }
}
