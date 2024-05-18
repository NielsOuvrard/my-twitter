<?php

require_once ($base_path . 'controllers' . DS . 'AuthController.php');
require_once ($base_path . 'controllers' . DS . 'MessagesController.php');
require_once ($base_path . 'controllers' . DS . 'PublicationsController.php');
require_once ($base_path . 'controllers' . DS . 'RelationshipsController.php');
require_once ($base_path . 'controllers' . DS . 'UserController.php');

$controllers = [
    'AuthController',
    'MessagesController',
    'PublicationsController',
    'RelationshipsController',
    'UserController',
];

// grab routes from all controllers
$all_routes = [];
foreach ($controllers as $controller) {
    if (class_exists($controller)) {
        $controller = new $controller;
        $routes = $controller->getRoutes();
        foreach ($routes as $route) {
            $route['controller'] = get_class($controller) . '::' . $route['controller'];
            $all_routes[] = $route;
        }
    }
}


function is_valid_path_method($route, $requestUri)
{
    $uriSegments = explode('/', rtrim($requestUri, '/'));
    $routeSegments = explode('/', rtrim($route['uri'], '/'));

    for ($i = 0; $i < count($routeSegments); $i++) {
        if ($routeSegments[$i] === '{id}' && is_numeric($uriSegments[$i])) {
            continue;
        }
        if ($routeSegments[$i] !== $uriSegments[$i]) {
            return false;
        }
    }

    if (count($uriSegments) !== count($routeSegments)) {
        return false;
    }

    if ($route['method'] !== $_SERVER['REQUEST_METHOD']) {
        return false;
    }

    return true;
}

function route_exists($routes, $requestUri)
{
    foreach ($routes as $route) {
        if (is_valid_path_method($route, $requestUri)) {
            return $route;
        }
    }
    return null;
}

$requestUri = $_SERVER['QUERY_STRING'];

// Route the request
if ($route = route_exists($all_routes, $requestUri)) {
    if ($route['auth'] === true && !$is_authenticated) {
        http_response_code(401);
        echo json_encode(['error' => 'You should be authenticated to access this route']);
    } else if ($route['admin'] === true && !$is_admin) {
        http_response_code(403);
        echo json_encode(['error' => 'You do not have permission to access this route']);
    } else {
        call_user_func($route['controller']);
    }
} else {
    // Route not found
    http_response_code(404);
    echo json_encode(['error' => 'Route Not Found']);
}
