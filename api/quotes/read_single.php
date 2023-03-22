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

// Get ID
if (isset($_GET['id'])) {
    $quote->id = $_GET['id'];
}
if (isset($_GET['author_id'])) {
    $quote->author_id = $_GET['author_id'];
}
if (isset($_GET['category_id'])) {
    $quote->category_id = $_GET['category_id'];
}

if ($quote->id == null && $quote->author_id == null && $quote->category_id == null) {
    die();
}

if ($quote->author_id == null && $quote->category_id == null) {
    $result = $quote->read_single();
    $num = $result->rowCount();
    
    if ($num > 0) {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        extract($row);

        $quote_item = array(
            'id' => $id,
            'quote' => $quote,
            'author' => $author,
            'category' => $category
        );

        echo json_encode($quote_item);
    } else {
        // if no quotes
        echo json_encode(array('message' => 'No Quotes Found'));
    }
    die();
}

// Calling read_single funciton in model file to execute Get request
$result = $quote->read_single();

$num = $result->rowCount();

// If there are quotes in database table
if ($num > 0) {
    $quote_arr = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $quote_item = array(
            'id' => $id,
            'quote' => $quote,
            'author' => $author,
            'category' => $category
        );

        array_push($quote_arr, $quote_item);
    }

    print_r(json_encode($quote_arr));
} else {
    // if no quotes
    echo json_encode(array('message' => 'No Quotes Found'));
}
