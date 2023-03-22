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

// Get ID
$category->id = isset($_GET['id']) ? $_GET['id'] : die();

// Calling read_single funciton in model file to execute Get request
$category->read_single();

$category_arr = array(
    'id' => $category->id,
    'category' => $category->category
);

print_r(json_encode($category_arr));
