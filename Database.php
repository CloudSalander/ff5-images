<?php
namespace App\Models;
use \mysqli;
include 'config.php';


class Database
{
    private mysqli $connection;

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        $config = include 'config.php';

        $database = 'ff5images_test';
        if($config['env'] === 'prod') $database = 'ff5images';

        $this->connection = new mysqli($config['host'], $config['user'], $config['password'], $database);
       
        if ($this->connection->connect_error) {
            die("Connection Error " . $this->connection->connect_error);
        }
    }

    public function getConnection(): mysqli
    {
        return $this->connection;
    }

    public function closeConnection(): void
    {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}