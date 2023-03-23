<?php
// Alex Lund
// INF 653 Backend Web Dev
// Midterm Project PHP OOP REST API
// turn in: March 22, 2023

class Author
{
    private $connection;
    private $table = 'authors';

    public $id;
    public $author;

    public function __construct($db)
    {
        $this->connection = $db;
    }

    public function read()
    {
        $query = 'SELECT id, author FROM ' . $this->table;

        // Use PDO to prepare and execute statement
        $stmt = $this->connection->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function read_single()
    {
        if ($this->id == null) {
            $query = 'SELECT id, author FROM ' . $this->table . ' WHERE author = ? LIMIT 1';

            // Use PDO to prepare and execute statement
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(1, $this->author); // sets id in WHERE clause to whatever was sent in request
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row == null) {
                echo json_encode(array('message' => 'author_id Not Found'));
                die();
            }

            $this->id = $row['id'];
            $this->author = $row['author'];

            return $stmt;
        }
        
        $query = 'SELECT id, author FROM ' . $this->table . ' WHERE id = ? LIMIT 1';

        // Use PDO to prepare and execute statement
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $this->id); // sets id in WHERE clause to whatever was sent in request
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row == null) {
            echo json_encode(array('message' => 'author_id Not Found'));
            die();
        }

        $this->id = $row['id'];
        $this->author = $row['author'];

        return $stmt;
    }

    // Create table item based on POST request
    public function create()
    {
        $query = 'INSERT INTO ' . $this->table . ' (author) VALUES (?)';

        // Use PDO to prepare and execute statement
        $stmt = $this->connection->prepare($query);

        // Clean data
        $this->author = htmlspecialchars(strip_tags($this->author));

        $stmt->bindParam(1, $this->author);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo json_encode(array('message' => 'author_id Not Found'));
            die();
        }
    }

    // Update table item based on PUT request
    public function update()
    {
        $query = 'UPDATE ' . $this->table . ' SET author = :author WHERE id = :id';

        // Use PDO to prepare and execute statement
        $stmt = $this->connection->prepare($query);

        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->author = htmlspecialchars(strip_tags($this->author));

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':author', $this->author);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo json_encode(array('message' => 'author_id Not Found'));
            return false;
        }
    }

    public function delete()
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        // Use PDO to prepare and execute query statement
        $stmt = $this->connection->prepare($query);

        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id', $this->id);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo json_encode(array('message' => 'No Quotes Found'));
            return false;
        }
    }
}
