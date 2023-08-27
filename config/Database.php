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

    // Private methods
    private function query($sql)
    {
        $this->stmt = $this->pdo->prepare($sql);
    }

    private function execute(...$args)
    {
        $this->stmt->execute(...$args);
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    static private function questionMarks($arg) { //values to question mark (mapping for sql query)
        return '?';
    }
// CREATE
    public function insert(array $columnNames, array $values) {
        if(count($columnNames) !== count($values)) {
            throw new Exception('Column count doesn\'t match value count');
        }
        $this->query('INSERT INTO users ('. implode(', ',$columnNames). ') VALUES (' . implode(', ', array_map('Database::questionMarks', $values)) .')' );
        return $this->execute($values);
    }

    // READ 
    public function selectOne(string $column, string $value) {
        // ("SELECT * FROM users WHERE username = ?", $this->username)[0]
        // WHERE (state = 'California' AND supplier_id <> 900)
        $test = "SELECT * FROM users WHERE $column = ? ";
        $this->query("SELECT * FROM users WHERE $column = ? ");
        return $this->execute([$value])[0];
    }
}
