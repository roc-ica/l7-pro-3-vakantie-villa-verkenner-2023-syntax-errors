<?php

class Database {

    private $host = getenv('MYSQL_HOST');
    private $user = getenv('MYSQL_USER');
    private $pass = getenv('MYSQL_PASSWORD');
    private $dbname = getenv('MYSQL_DATABASE');

    public $pdo;

    public function __construct() {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ];
        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $e->getMessage();
        }
    }
}