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
include_once '../../models/Quote.php';

// establishing database connection and relevant parameters
$database = new Database();
$db = $database->connect();

$quote = new Quote($db);

$data = json_decode(file_get_contents("php://input"));

if (!property_exists($data, 'id') || !property_exists($data, 'quote') || !property_exists($data, 'author_id') || !property_exists($data, 'category_id')) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    die();
}

$quote->id = $data->id;
$quote->quote = $data->quote;
$quote->author_id = $data->author_id;
$quote->category_id = $data->category_id;

$quote->update();

$quote->read_single();

$quote_item = array(
    'id' => $quote->id,
    'quote' => $quote->quote,
    'author_id' => $quote->author_id,
    'category_id' => $quote->category_id
);

echo json_encode($quote_item);
