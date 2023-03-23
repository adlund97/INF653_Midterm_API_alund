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

if (!property_exists($data, 'id') || !property_exists($data, 'author')) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    die();
}

$author->id = $data->id;
$author->author = $data->author;

$author->update();

$author->read_single();

$author_item = array(
    'id' => $author->id,
    'author' => $author->author
);

echo json_encode($author_item);
