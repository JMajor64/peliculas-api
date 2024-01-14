<?php

class DatabaseService
{
    private $host;
    private $username;
    private $password;
    private $database;
    private $connection;

    public function __construct($host = 'localhost', $username = 'homestead', $password = 'secret', $database = 'peliculas')
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }

    public function connect() {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
        
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function disconnect() {
        $this->connection->close();
    }

    public function select($query) {
        $result = $this->connection->query($query);

        if ($result === false) {
            die("Error executing query: " . $this->connection->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function insert($query) {
        $result = $this->connection->query($query);

        if ($result === false) {
            die("Error executing query: " . $this->connection->error);
        }

        return $this->connection->insert_id;
    }

    public function update($query) {
        $result = $this->connection->query($query);

        if ($result === false) {
            die("Error executing query: " . $this->connection->error);
        }

        return $this->connection->affected_rows;
    }

    public function delete($query) {
        $result = $this->connection->query($query);

        if ($result === false) {
            die("Error executing query: " . $this->connection->error);
        }

        return $this->connection->affected_rows;
    }
}