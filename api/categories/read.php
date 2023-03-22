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
include_once '../../models/Category.php';

// establishing database connection and relevant parameters
$database = new Database();
$db = $database->connect();

$category = new Category($db);

// Calling read funciton in model file to execute Get request
$result = $category->read();
$num = $result->rowCount();

// If there are categories in database table
if ($num > 0) {
    $category_arr = array();
    $category_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $category_item = array(
            'id' => $id,
            'category' => $category
        );

        array_push($category_arr['data'], $category_item);
    }

    echo json_encode($category_arr);
} else {
    // if no categories
    echo json_encode(array('message' => 'No categories found'));
}
