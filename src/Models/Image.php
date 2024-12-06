<?php

namespace App\Models;

class Image
{

 private ?int $id;
    private string $title;
    private string $path;

    public function __construct(string $title, string $path, ?int $id = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->path = $path;
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

    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'path' => $this->path,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['title'],
            $data['path'],
            $data['id'] ?? null
        );
    }
}
