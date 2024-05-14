<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: *');
header('Referrer-Policy: strict-origin-when-cross-origin');

const DS = DIRECTORY_SEPARATOR;

$base_path = realpath(dirname(__FILE__)) . DS . 'backend' . DS;

require_once('backend/utils/jwt.php');

$is_admin = false;
$is_authenticated = false;

if ($_SERVER['HTTP_AUTHORIZATION']) {
    $token = $_SERVER['HTTP_AUTHORIZATION'];

    if (JWT::isValid($token) && !JWT::isExpired($token) && JWT::check($token, getenv('JWT_SECRET_KEY'))) {
        $is_authenticated = true;
        $payload = JWT::getPayload($token);
        $is_admin = $payload['admin'];
    }
}

require_once('backend/routes/routes.php');
