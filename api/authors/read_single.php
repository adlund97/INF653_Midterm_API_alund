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
include_once '../../models/Author.php';

// establishing database connection and relevant parameters
$database = new Database();
$db = $database->connect();

$author = new Author($db);

// Get ID
$author->id = isset($_GET['id']) ? $_GET['id'] : die();

// Calling read_single funciton in model file to execute Get request
$author->read_single();

$author_arr = array(
    'id' => $author->id,
    'author' => $author->author
);

print_r(json_encode($author_arr));
