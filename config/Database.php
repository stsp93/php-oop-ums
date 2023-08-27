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

    public function query(string $sql,array ...$params)
    {
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute([...$params]);
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
