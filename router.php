<?php

function route(string $method, string $path): mixed
{
    //Three dimensions array...sorry ;(
    $routes = [
        'GET' => 
            ['images' => 
                ['controller' => 'App\Controllers\ImagesController', 'action' => 'get']
            ], 
        'POST' => 
            ['images' => 
                ['controller' => 'App\Controllers\ImagesController', 'action' => 'create','validator' => 'App\Controllers\RequestValidators\PostImages']
            ],
    ];

    if(in_array($method,array_keys($routes)) && in_array($path,array_keys($routes[$method]))) {
        $controllerInstance = new $routes[$method][$path]['controller']();
        $controllerMethod = $routes[$method][$path]['action'];
        if(isset($routes[$method][$path]['validator'])) {
            $requestValidator = new $routes[$method][$path]['validator']();
            return call_user_func_array([$controllerInstance, $controllerMethod],['validator' => $requestValidator]);
        }
        else {
            return call_user_func_array([$controllerInstance, $controllerMethod],[]);
        }
    }
    http_response_code(404);
    return ['status' => 'error', 'message' => 'Route not found'];
}

