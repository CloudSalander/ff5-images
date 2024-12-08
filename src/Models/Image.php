<?php

namespace App\Models;
use App\Models\ImageTransformations\GrayScale;
use App\Models\ImageTransformations\ColorsInversion;
use App\Models\ImageTransformations\ImagePixelation;

class Image
{
    private ?int $id;
    private string $title;
    private string $path;
    private \mysqli $conn;

    private const UPLOAD_DIR = 'uploads';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function setData(?int $id = null)
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
        
        $result = false;
    
        $sql = "INSERT INTO images (title, path) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;
        
        $stmt->bind_param("ss", $this->title, $this->path);
        if ($stmt->execute()) $result = true;

        $stmt->close();

        return $result;
    }

    public function getImages(): bool | array {
        $result = false;
        
        $sql = "SELECT id,title,path as image FROM images";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return false;
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $result = $result->fetch_all(MYSQLI_ASSOC);
        }
        $stmt->close();
        return $result;
    }

    public function getImageById(int $id): bool | array {
        $result = false;

        $sql = "SELECT id,title,path as image FROM images WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $result = $result->fetch_assoc();
            if(is_null($result)) $result = false;
        }
        $stmt->close();
       
        return $result;
    }

    public function updateImageById(int $id): bool|array {
        $result = false;
        $image = $this->getImageById($id);
        if(!$image) return false;
        if($_POST['effect'] != "") {
            //TODO: Improve ImageIntervention Error Handling
            $this->transformImage($image['image']);
            $result = true;
        }
        if($_POST['title'] != "") {
            $sql = "UPDATE images SET title = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            
            $stmt->bind_param("si", $_POST['title'],$id);
            if ($stmt->execute()) {
                if($stmt->affected_rows > 0) $result = true;
            }
            $stmt->close();
        }
        return $result;
    }
    
    private function transformImage(string $imagePath): void {
        match($_POST['effect']) {
            'grayscale' => new GrayScale($imagePath),
            'invert' => new ColorsInversion($imagePath),
            'pixelate' => new ImagePixelation($imagePath)
        };
    }

    public function deleteImageById(int $id): bool {
        $image_row = $this->getImageById($id);
        return $this->deleteRow($id) && unlink($image_row['image']);
    }


    private function deleteRow(int $id): bool {
        $result = false;
    
        $sql = "DELETE from images WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            if($stmt->affected_rows > 0) $result = true;
        }
        $stmt->close();
        return $result;
    }
    

    public function __destruct()
    {
        $this->conn->close();
    }
}
