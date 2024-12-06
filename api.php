<?php
namespace App;
require 'vendor/autoload.php';
require_once 'Database.php';
require_once 'router.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

const ALLOWED_PATHS = ['images'];
const ALLOWED_ACTIONS = ['GET','POST','PUT','DELETE'];

$method = $_SERVER['REQUEST_METHOD'];
$requestUri = trim($_SERVER['REQUEST_URI'], '/');
$segments = explode('/', $requestUri);
$body = file_get_contents('php://input');
if (isValidCall($method,$segments)) {
   http_response_code(200);
   route($method,$segments[1],$_POST);
}  
else {
    http_response_code(404);
}

function isValidCall(string $method, array $segments): bool {
    return in_array($method,ALLOWED_ACTIONS) && in_array($segments[1], ALLOWED_PATHS);
}
/*
function validateAndReturnBody(string $jsonString): mixed {
    $data = json_decode($jsonString,true);
    if (json_last_error() !== JSON_ERROR_NONE || is_null($data)) return [];
    return $data;
} */