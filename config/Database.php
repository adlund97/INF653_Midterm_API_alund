<?php
// Alex Lund
// INF 653 Backend Web Dev
// Midterm Project PHP OOP REST API
// turn in: March 22, 2023

class Database
{
    // Parameters for our database
    private $host = 'localhost';
    private $port = '5432';
    private $dbname = 'quotesdb';
    private $username = 'postgres';
    private $password = 'postgres';
    private $connection;

    public function __construct()
    {
        $this->username = getenv('USERNAME');
        $this->password = getenv('PASSWORD');
        $this->dbname = getenv('DBNAME');
        $this->host = getenv('HOST');
        $this->port = getenv('PORT');
    }

    // function form establishing database connection
    public function connect()
    {
        if ($this->connection) {
            return $this->connection;
        } else {
            $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbname};";

            try {
                $this->connection = new PDO($dsn, $this->username, $this->password);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $this->connection;
            } catch (PDOException $e) {
                echo 'Conection Error: ' . $e->getMessage();
            }
        }
    }
}
