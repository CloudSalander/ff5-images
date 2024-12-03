<?php 

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class BaseTest extends TestCase {
    
    protected Client $client;

    protected function setUp(): void
    {
        // Configura el cliente HTTP
        $this->client = new Client([
            'base_uri' => 'http://localhost/ff5-images/', // URL base de tu API
            'timeout'  => 5.0, // Tiempo máximo para una respuesta
        ]);
    }
}
