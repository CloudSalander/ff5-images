<?php

namespace App\Models;
class Image
{
    private ?int $id;
    private string $title;
    private string $path;

    private const UPLOAD_DIR = 'uploads';

    public function __construct(?int $id = null)
    {
        $this->id = $id;
        $this->title = $_POST['title'];
        $this->path = $this->createPath();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }


    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'path' => $this->path,
        ];
    }

    private function createPath(): string {
        $fileName = $_FILES['image']['name'];
        return self::UPLOAD_DIR."/".time()."_".$fileName;
    }

    public function save(): bool {
        if($this->saveFile() && $this->saveRow()) return true;
        else return false; 
    }

    private function saveFile(): bool {
        return move_uploaded_file($_FILES['image']['tmp_name'], $this->path);
    }

    private function saveRow(): bool {
        $database = new Database();
        $result = false;

        $conn = $database->getConnection();
        if ($conn->connect_error) return false;
        
        $sql = "INSERT INTO images (title, path) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) return false;
        
        $stmt->bind_param("ss", $this->title, $this->path);
        if ($stmt->execute()) $result = true;

        $stmt->close();
        $conn->close();

        return $result;
    }


}
