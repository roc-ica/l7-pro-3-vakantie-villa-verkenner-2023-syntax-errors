<?php

class Database {
    private $host;
    private $user;
    private $pass;
    private $dbname;
    public $pdo;

    public function __construct() {
        $this->host = getenv('MYSQL_HOST');
        $this->user = getenv('MYSQL_USER');
        $this->pass = getenv('MYSQL_PASSWORD');
        $this->dbname = getenv('MYSQL_DATABASE');

        $dsn = "mysql:host=".$this->host.";dbname=".$this->dbname.";charset=utf8mb4";
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ];

        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
}
