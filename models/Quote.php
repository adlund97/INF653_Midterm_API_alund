<?php
// Alex Lund
// INF 653 Backend Web Dev
// Midterm Project PHP OOP REST API
// turn in: March 22, 2023

class Quote
{
  private $connection;
  private $table = 'quotes';

  public $id;
  public $quote;
  public $author_id;
  public $category_id;
  public $author;
  public $category;

  public function __construct($db)
  {
    $this->connection = $db;
  }

  public function read()
  {
    $query = 'SELECT 
                  q.id, 
                  q.quote,
                  a.author AS author,
                  c.category AS category
              FROM 
                  ' . $this->table . ' AS q
              LEFT OUTER JOIN
                  categories AS c ON q.category_id = c.id
              LEFT OUTER JOIN
                  authors AS a ON q.author_id = a.id
              ORDER BY id ASC';

    // Use PDO to prepare and execute statement
    $stmt = $this->connection->prepare($query);
    $stmt->execute();

    return $stmt;
  }

  public function read_single()
  {
    $case = 0;
    if ($this->id !== null) {
      $case = 1;
      $query = 'SELECT 
                  q.id, 
                  q.quote,
                  a.author AS author,
                  c.category AS category
                FROM 
                  ' . $this->table . ' AS q
                LEFT OUTER JOIN
                  categories AS c ON q.category_id = c.id
                LEFT OUTER JOIN
                  authors AS a ON q.author_id = a.id
                WHERE q.id = :id';
    } else if ($this->author_id !== null && $this->category_id !== null) {
      $case = 2;
      $query = 'SELECT 
                  q.id, 
                  q.quote,
                  a.author AS author,
                  c.category AS category
                FROM 
                  ' . $this->table . ' AS q
                LEFT OUTER JOIN
                  categories AS c ON q.category_id = c.id
                LEFT OUTER JOIN
                  authors AS a ON q.author_id = a.id
                WHERE q.author_id = :author_id AND q.category_id = :category_id
                ORDER BY id ASC';
    } else if ($this->author_id !== null && $this->category_id == null) {
      $case = 3;
      $query = 'SELECT 
                  q.id, 
                  q.quote,
                  a.author AS author,
                  c.category AS category
                FROM 
                  ' . $this->table . ' AS q
                LEFT OUTER JOIN
                  categories AS c ON q.category_id = c.id
                LEFT OUTER JOIN
                  authors AS a ON q.author_id = a.id
                WHERE q.author_id = :author_id
                ORDER BY id ASC';
    } else {
      $case = 4;
      $query = 'SELECT 
                  q.id, 
                  q.quote,
                  a.author AS author,
                  c.category AS category
                FROM 
                  ' . $this->table . ' AS q
                LEFT OUTER JOIN
                  categories AS c ON q.category_id = c.id
                LEFT OUTER JOIN
                  authors AS a ON q.author_id = a.id
                WHERE q.category_id = :category_id
                ORDER BY id ASC';
    }

    // Use PDO to prepare and execute statement
    $stmt = $this->connection->prepare($query);

    switch ($case) {
      case 1:
        $stmt->bindParam(':id', $this->id); // sets id in WHERE clause to whatever was sent in request
        break;
      case 2:
        $stmt->bindParam(':author_id', $this->author_id); // sets id in WHERE clause to whatever was sent in request
        $stmt->bindParam(':category_id', $this->category_id); // sets id in WHERE clause to whatever was sent in request
        break;
      case 3:
        $stmt->bindParam(':author_id', $this->author_id); // sets id in WHERE clause to whatever was sent in request
        break;
      case 4:
        $stmt->bindParam(':category_id', $this->category_id); // sets id in WHERE clause to whatever was sent in request
        break;
    }

    $stmt->execute();

    return $stmt;
  }

  // Create table item based on POST request
  public function create()
  {
    $query = 'INSERT INTO ' . $this->table . ' (quote, author_id, category_id) VALUES (:quote, :author_id, :category_id)';

    // Use PDO to prepare and execute statement
    $stmt = $this->connection->prepare($query);

    // Clean data
    $this->quote = htmlspecialchars(strip_tags($this->quote));
    $this->author_id = htmlspecialchars(strip_tags($this->author_id));
    $this->category_id = htmlspecialchars(strip_tags($this->category_id));

    $stmt->bindParam(':quote', $this->quote);
    $stmt->bindParam(':author_id', $this->author_id);
    $stmt->bindParam(':category_id', $this->category_id);

    try {
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      echo json_encode(array('message' => 'either author_id or category_id Not Found'));
      return false;
    }
  }

  // Update table item based on PUT request
  public function update()
  {
    $query = 'UPDATE ' . $this->table . ' SET quote = :quote, author_id = :author_id, category_id = :category_id WHERE id = :id';

    // Use PDO to prepare and execute statement
    $stmt = $this->connection->prepare($query);

    // Clean data
    $this->id = htmlspecialchars(strip_tags($this->id));
    $this->quote = htmlspecialchars(strip_tags($this->quote));
    $this->author_id = htmlspecialchars(strip_tags($this->author_id));
    $this->category_id = htmlspecialchars(strip_tags($this->category_id));

    $stmt->bindParam(':id', $this->id);
    $stmt->bindParam(':quote', $this->quote);
    $stmt->bindParam(':author_id', $this->author_id);
    $stmt->bindParam(':category_id', $this->category_id);

    try {
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      echo json_encode(array('message' => 'either author_id or category_id Not Found'));
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
