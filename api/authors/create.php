<?php
// Alex Lund
// INF 653 Backend Web Dev
// Midterm Project PHP OOP REST API
// turn in: March 22, 2023

// Creating necessary headings
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// Include appropriate files for the requests
include_once '../../config/Database.php';
include_once '../../models/Author.php';

// establishing database connection and relevant parameters
$database = new Database();
$db = $database->connect();

$author = new Author($db);

$data = json_decode(file_get_contents("php://input"));

if ($data->author == null) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit();
}

$author->author = $data->author;

$author->create();

$row = $result->fetch(PDO::FETCH_ASSOC);
extract($row);

$author_item = array(
    'id' => $author->id,
    'author' => $author->author
);

echo json_encode($author_item);

/*
if ($author->author !== null) {
    // Calling create funciton in model file to execute POST request
    if ($author->create()) {
        echo json_encode(array('message' => 'Quote Created'));
    } else {
        echo json_encode(array('message' => 'Quote Not Created'));
    }
}
