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
include_once '../../models/Category.php';

// establishing database connection and relevant parameters
$database = new Database();
$db = $database->connect();

$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

if (!property_exists($data, 'id') || !property_exists($data, 'category')) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    die();
}

$category->id = $data->id;
$category->category = $data->category;

$category->update();

$category->read_single();

$category_item = array(
    'id' => $category->id,
    'category' => $category->category
);

echo json_encode($category_item);
