<?php
namespace App;
error_reporting(E_ALL & ~E_WARNING);

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

if (isValidCall($method,$segments)) {
   http_response_code(200);
   route($method,$segments);
}  
else {
    http_response_code(404);
}

function isValidCall(string $method, array $segments): bool {
    return in_array($method,ALLOWED_ACTIONS) && in_array($segments[1], ALLOWED_PATHS);
}
