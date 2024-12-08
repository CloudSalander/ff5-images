<?php 

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class BaseTest extends TestCase {
    
    protected Client $client;
    protected const SAMPLE_IMAGE_PATH = __DIR__.'/images/image1.jpg';
    private array $dbConfig;

    protected function setUp(): void
    {
        $this->client = new Client([
            'base_uri' => 'http://localhost/ff5-images/', 
            'timeout'  => 5.0,
            'http_errors' => false 
        ]);
        $this->dbConfig = [
            'host' => 'localhost',
            'user' => 'root',
            'password' => '',
            'database' => 'ff5images_test'
        ];
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

    protected function clearImagesTable(): void
    {
        $connection = $this->prepareConnection();
        $sql = "TRUNCATE table images";
        $stmt = $connection->prepare($sql);
        $stmt->execute();

        $stmt->close();
        $connection->close();
    }

    protected function insertImages($n_images = 3): void {
        $connection = $this->prepareConnection();
        for($con = 1; $con <= $n_images; ++$con) {
            $fileTitle = "image".$con;
            $filePath = "images/image1.jpg";
            move_uploaded_file(__DIR__."/".$filePath,'uploads'.$fileTitle);
            $sql = "INSERT INTO images (title, path) VALUES (?, ?)";
            $stmt = $connection->prepare($sql);
            if (!$stmt) die("Something was wrong");
        
            $stmt->bind_param("ss", $fileTitle, $filePath);
            $stmt->execute();
            $stmt->close();
        }
        $connection->close();
    }

    private function prepareConnection(): mixed
    {
        $connection = new mysqli($this->dbConfig['host'], $this->dbConfig['user'], $this->dbConfig['password'], $this->dbConfig['database']);
        if ($connection->connect_error) {
            die("Connection Error " . $connection->connect_error);
        }
        return $connection;
    }
}
