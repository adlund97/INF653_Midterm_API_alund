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
include_once '../../models/Quote.php';

// establishing database connection and relevant parameters
$database = new Database();
$db = $database->connect();

$quote = new Quote($db);

// Calling read funciton in model file to execute Get request
$result = $quote->read();
$num = $result->rowCount();

// If there are quotes in database table
if ($num > 0) {
    $quote_arr = array();
    $quote_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $quote_item = array(
            'id' => $id,
            'quote' => $quote,
            'author' => $author,
            'category' => $category
        );

        array_push($quote_arr['data'], $quote_item);
    }

    echo json_encode($quote_arr);
} else {
    // if no quotes
    echo json_encode(array('message' => 'No quotes found'));
}
