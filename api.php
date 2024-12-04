<?php

include('Database.php');

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$method = $_SERVER['REQUEST_METHOD'];
$requestUri = trim($_SERVER['REQUEST_URI'], '/');
$segments = explode('/', $requestUri);

if (isValidCall($method,$segments)) {
   http_response_code(200);
   $db = new Database();
   var_dump($db);
}  
else {
    http_response_code(404);
}

function isValidCall(string $method, array $segments): bool {
    return true;
}