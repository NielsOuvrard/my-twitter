<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: *');
header('Referrer-Policy: strict-origin-when-cross-origin');


// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit(0);
}

const DS = DIRECTORY_SEPARATOR;

$base_path = realpath(dirname(__FILE__)) . DS;

require_once($base_path . '/utils/jwt.php');

$is_admin = false;
$is_authenticated = false;

if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
    $token = $_SERVER['HTTP_AUTHORIZATION'];

    if (JWT::isValid($token) && !JWT::isExpired($token) && JWT::check($token, getenv('JWT_SECRET_KEY'))) {
        $is_authenticated = true;
        $payload = JWT::getPayload($token);
        $is_admin = $payload['admin'];
    }
}

// Log the request for debugging
file_put_contents('request.log', date('Y-m-d H:i:s') . ' - ' . $_SERVER['REQUEST_METHOD'] . ' - ' . file_get_contents('php://input') . "\n", FILE_APPEND);

require_once($base_path . '/routes/routes.php');
