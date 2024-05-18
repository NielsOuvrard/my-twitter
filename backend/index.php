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

require_once ($base_path . '/utils/jwt.php');

$is_admin = false;
$is_authenticated = false;

if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
    $token = str_replace('Bearer ', '', $_SERVER['HTTP_AUTHORIZATION']);

    $is_jwt = JWT::isValid($token);
    $is_expierd = JWT::isExpired($token);
    $is_valid = JWT::check($token, getenv('JWT_SECRET_KEY'));

    if ($is_jwt && !$is_expierd && $is_valid) {
        $is_authenticated = true;
        $payload = JWT::getPayload($token);
        // $is_admin = $payload['admin']; // todo another way with sql db

        $_SERVER['JWT_PAYLOAD'] = $payload;
    } else if ($is_expierd) {
        http_response_code(401);
        echo json_encode(['error' => 'Your jwt token is expired']);
    } else if (!$is_valid) {
        http_response_code(401);
        echo json_encode(['error' => 'Your jwt token is invalid']);
    }
}

// Log the request for debugging
file_put_contents('request.log', date('Y-m-d H:i:s') . ' - ' . $_SERVER['REQUEST_METHOD'] . ' - ' . $_SERVER['REQUEST_URI'] . PHP_EOL, FILE_APPEND);

require_once ($base_path . '/routes/routes.php');
