<?php

namespace App;

use PDO;
use PDOException;

class Database
{
    private ?PDO $connection = null;

    public function connect(): PDO
    {
        if (isset($this->connection)) {
            return $this->connection;
        }

        try {
            $this->connection = new PDO('sqlite:' . Config::PATH_TO_SQLITE_DB);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e)
        {
            echo "Connection Error: " . $e->getMessage();
        }

        return $this->connection;
    }

    public function __destruct()
    {
        $this->disconnect();
    }

    public function disconnect(): void
    {
        if (isset($this->connection)) {
            $this->connection = null;
        }
    }
}