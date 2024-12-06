<?php

function route(string $method, string $path): mixed
{
    $routes = [
        'images' => ['controller' => 'App\Controllers\ImagesController', 'action' => 'create'],
    ];

    foreach ($routes as $handler) {
        if(in_array($path,array_keys($routes))) {
            $controllerInstance = new $handler['controller']();
            $controllerMethod = $handler['action'];
            return call_user_func_array([$controllerInstance, $controllerMethod],['body' => $_POST, 'validator' => new App\Controllers\Validators\LargeTitle()]);
        }
    }
    http_response_code(404);
    return ['status' => 'error', 'message' => 'Route not found'];
}

