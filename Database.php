<?php

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
        $this->connection = new mysqli($config['host'], $config['user'], $config['password'], $config['db_name']);

        if ($this->connection->connect_error) {
            die("Error de conexión: " . $this->connection->connect_error);
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