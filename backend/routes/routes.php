<?php

require_once($base_path . 'controllers' . DS . 'UserController.php');
require_once($base_path . 'controllers' . DS . 'AuthController.php');
require_once($base_path . 'utils' . DS . 'db.php');


function is_valid_route($route, $requestUri)
{
    $uriSegments = explode('/', rtrim($requestUri, '/'));
    $routeSegments = explode('/', rtrim($route, '/'));

    for ($i = 0; $i < count($routeSegments); $i++) {
        if ($routeSegments[$i] === '{id}') {
            continue;
        }
        if ($routeSegments[$i] !== $uriSegments[$i]) {
            return false;
        }
    }

    return true;
}

function route_exists($routes_type, $requestUri)
{
    foreach ($routes_type as $routes) { // this will parcour 'public', 'auth', 'admin'
        foreach ($routes as $route) {
            if (is_valid_route($route['uri'], $requestUri)) {
                return true;
            }
        }
    }
    return false;
}

function check_route($routes, $requestUri)
{
    $method = $_SERVER['REQUEST_METHOD'];

    foreach ($routes as $route) {
        if ($route['method'] === $method && is_valid_route($route['uri'], $requestUri)) {
            $handler = $route['controller'];
            call_user_func($handler);
            return true;
        }
    }
    return false;
}

$routes = [
    // Public routes accessible without authentication
    'public' => [
        // Auth route
        [
            'uri' => '/login',
            'method' => 'POST',
            'controller' => 'AuthController::login',
        ],
        [
            'uri' => '/register',
            'method' => 'POST',
            'controller' => 'AuthController::register',
        ],
        // Users routes
        [
            'uri' => '/users',
            'method' => 'GET',
            'controller' => 'UserController::getAllUsers',
        ],
        [
            'uri' => '/user/{id}',
            'method' => 'GET',
            'controller' => 'UserController::getUserById',
        ],
    ],

    // Authenticated routes requiring JWT token
    'auth' => [
        // Auth route
        [
            'uri' => '/logout',
            'method' => 'POST',
            'controller' => 'AuthController::logout',
        ],
        // Users routes
        [
            'uri' => '/user/{id}',
            'method' => 'PUT',
            'controller' => 'UserController::updateUser',
        ],
        [
            'uri' => '/user/{id}',
            'method' => 'DELETE',
            'controller' => 'UserController::deleteUser',
        ],
        // Relationships routes
        [
            'uri' => '/relationships',
            'method' => 'GET',
            'controller' => 'RelationshipController::getRelationships',
        ],
        [
            'uri' => '/relationship/{id}',
            'method' => 'POST',
            'controller' => 'RelationshipController::createRelationship',
        ],
        [
            'uri' => '/relationship/{id}',
            'method' => 'PUT',
            'controller' => 'RelationshipController::updateRelationship',
        ],
        [
            'uri' => '/relationship/{id}',
            'method' => 'DELETE',
            'controller' => 'RelationshipController::deleteRelationship',
        ],
        // Messages routes
        [
            'uri' => '/message/{id}',
            'method' => 'POST',
            'controller' => 'MessageController::createMessage',
        ],
        [
            'uri' => '/message/{id}',
            'method' => 'PUT',
            'controller' => 'MessageController::updateMessage',
        ],
        [
            'uri' => '/message/{id}',
            'method' => 'DELETE',
            'controller' => 'MessageController::deleteMessage',
        ],
        [
            'uri' => '/messages/{id}',
            'method' => 'GET',
            'controller' => 'MessageController::',
        ],
    ],

    // Admin routes requiring admin privileges
    'admin' => [
        [
            'uri' => '/messages/{id}-{id}',
            'method' => 'GET',
            'controller' => 'MessageController::',
        ],
        [
            'uri' => '/relationship/{id}-{id}',
            'method' => 'GET',
            'controller' => 'RelationshipController::',
        ],
        [
            'uri' => '/relationships',
            'method' => 'GET',
            'controller' => 'RelationshipController::',
        ],
    ],
];


// Get the current request URI
$requestUri = $_SERVER['REQUEST_URI'];

// Remove query string from the URI
if (($pos = strpos($requestUri, '?')) !== false) {
    $requestUri = substr($requestUri, 0, $pos);
}

if (strpos($requestUri, '/api/') === 0) {
    $requestUri = preg_replace('#^/api/#', '/', $requestUri);
}

$is_authenticated = false;
$is_admin = false;

// echo json_encode(['requestUri' => $requestUri]);
// echo json_encode(['array_keys of routes' => array_keys($routes)]);

// Route the request
if (route_exists($routes, $requestUri)) {
    $method = $_SERVER['REQUEST_METHOD'];

    if (check_route($routes['public'], $requestUri)) {
        return;
    }
    if ($is_authenticated && check_route($routes['auth'], $requestUri)) {
        return;
    }
    if ($is_admin && check_route($routes['admin'], $requestUri)) {
        return;
    }

    http_response_code(405);
    echo json_encode(['error' => 'You do not have permission to access this route']);
} else {
    // Route not found
    http_response_code(404);
    echo json_encode(['error' => 'Route Not Found']);
}
