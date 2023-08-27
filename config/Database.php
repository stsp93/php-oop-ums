<?php
class Database
{
    private $host = 'localhost';
    private $db_name = 'task7';
    private $username = 'username';
    private $password = 'password';
    private $pdo;
    private $stmt;
    private $error;

    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    private function query($sql)
    {
        $this->stmt = $this->pdo->prepare($sql);
    }

    private function execute(...$args)
    {
        $this->stmt->execute(...$args);
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
// CREATE
    public function insert(array $columNames, array $values) {
        function questionMarks($arg) {
            return '?';
        }
        $this->query('INSERT INTO users ('. implode(', ',$columNames). ') VALUES (' . implode(', ', array_map('questionMarks', $values)) .')' );
        return $this->execute($values);
    }
}
