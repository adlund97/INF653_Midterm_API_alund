<?php
// Alex Lund
// INF 653 Backend Web Dev
// Midterm Project PHP OOP REST API
// turn in: March 22, 2023

// Creating necessary headings
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// Include appropriate files for the requests
include_once '../../config/Database.php';
include_once '../../models/Author.php';

// establishing database connection and relevant parameters
$database = new Database();
$db = $database->connect();

$author = new Author($db);

$data = json_decode(file_get_contents("php://input"));

if ($data->id == null) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit();
}

if ($data->author == null) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit();
}

$author->id = $data->id;
$author->author = $data->author;

// Calling create funciton in model file to execute PUT request
if ($author->update()) {
    echo json_encode(array('message' => 'Quote Updated'));
} else {
    echo json_encode(array('message' => 'Quote Not Updated'));
}
