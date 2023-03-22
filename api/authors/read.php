<?php
// Alex Lund
// INF 653 Backend Web Dev
// Midterm Project PHP OOP REST API
// turn in: March 22, 2023

// Creating necessary headings
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Include appropriate files for the requests
include_once '../../config/Database.php';
include_once '../../models/Author.php';

// establishing database connection and relevant parameters
$database = new Database();
$db = $database->connect();

$author = new Author($db);

// Calling read funciton in model file to execute Get request
$result = $author->read();
$num = $result->rowCount();

// If there are authors in database table
if ($num > 0) {
    $author_arr = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $author_item = array(
            'id' => $id,
            'author' => $author
        );

        array_push($author_arr, $author_item);
    }

    echo json_encode($author_arr);
} else {
    // if no authors
    echo json_encode(array('message' => 'No authors found'));
}
