<?php

class DatabaseMySQL {
    private $host;
    private $port;
    private $dbname;
    private $username;
    private $password;
    private $pdo;

    public function __construct() {
        // Configurações MySQL
        $this->host = 'localhost';
        $this->port = '3306';
        $this->dbname = 'sistema_votacao';
        $this->username = 'root';
        $this->password = 'gordo123';
    }

    public function connect() {
        try {
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->dbname};charset=utf8mb4";
            $this->pdo = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
            return $this->pdo;
        } catch (PDOException $e) {
            error_log("Erro de conexão com o banco de dados MySQL: " . $e->getMessage());
            throw new Exception("Erro de conexão com o banco de dados");
        }
    }

    public function getConnection() {
        if ($this->pdo === null) {
            $this->connect();
        }
        return $this->pdo;
    }

    public function close() {
        $this->pdo = null;
    }
}