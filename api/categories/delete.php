<?php
// Alex Lund
// INF 653 Backend Web Dev
// Midterm Project PHP OOP REST API
// turn in: March 22, 2023

// Creating necessary headings
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// Include appropriate files for the requests
include_once '../../config/Database.php';
include_once '../../models/Category.php';

// establishing database connection and relevant parameters
$database = new Database();
$db = $database->connect();

$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

if ($data->id == null) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit();
}

$category->id = $data->id;

$name = $category->id;

// Calling Delete funciton in model file to execute Delete request
if ($category->delete()) {
    echo json_encode(array('message' => `Category ID: {$name} Delete`));
} else {
    echo json_encode(array('message' => 'Quote Not Delete'));
}
