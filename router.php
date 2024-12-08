<?php

function route(string $method, array $path): mixed
{
    $id = 0;
    if(isset($path[2])) $id = $path[2];
    $path = $path[1];
    //Three dimensions array...sorry ;(
    //Promise that the rest of the code apart of this file has better looking :)
    $routes = [
        'GET' => 
            ['images' => 
                ['controller' => 'App\Controllers\ImagesController', 'action' => 'get']
            ], 
        'POST' => 
            ['images' => 
                ['controller' => 'App\Controllers\ImagesController', 'action' => 'create','validator' => 'App\Controllers\RequestValidators\PostImages']
            ],
        'DELETE' =>
            ['images' => 
                ['controller' => 'App\Controllers\ImagesController', 'action' => 'delete']
            ]   
    ];

    if(in_array($method,array_keys($routes)) && in_array($path,array_keys($routes[$method]))) {
        $controllerInstance = new $routes[$method][$path]['controller']();
        $controllerMethod = $routes[$method][$path]['action'];
        $params = [];
        if(isset($routes[$method][$path]['validator'])) $params['validator'] =  new $routes[$method][$path]['validator']();
        if(is_numeric($id) &&  $id > 0 && $method != 'POST') $params['id'] = $id; 
        return call_user_func_array([$controllerInstance, $controllerMethod],$params);
    }
    http_response_code(404);
    return ['status' => 'error', 'message' => 'Route not found'];
}

