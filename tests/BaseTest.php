<?php 

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class BaseTest extends TestCase {
    
    protected Client $client;

    protected function setUp(): void
    {
        $this->client = new Client([
            'base_uri' => 'http://localhost/ff5-images/', 
            'timeout'  => 5.0,
            'http_errors' => false 
        ]);
    }

    protected function assertJSONResponse(string $body): mixed {
        $this->assertJson($body);
        return json_decode($body, true);
    }

    protected function assertResponseContent(mixed $data, string $message, string $code): void {
        $this->assertArrayHasKey('message', $data);
        $this->assertEquals($message, $data['message']);
        
        $this->assertArrayHasKey('code', $data);
        $this->assertEquals($code, $data['code']);
    }

    protected function getRandomString(int $n): string {
        return bin2hex(random_bytes($n / 2));
    }

    protected function generateWrongTitle(int $length = 16): string {
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
