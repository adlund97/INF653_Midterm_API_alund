<?php
// Alex Lund
// INF 653 Backend Web Dev
// Midterm Project PHP OOP REST API
// turn in: March 22, 2023

// storing type of request made to API as a variable
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

// Conditionals for getting appropriate files for each type of request
if ($method == 'GET') {
    isset($_GET['id']) ? require_once 'read_single.php' : require_once 'read.php';
} else if ($method == 'POST') {
    require_once 'create.php';
} else if ($method == 'PUT') {
    require_once 'update.php';
} else if ($method == 'DELETE') {
    require_once 'delete.php';
}
