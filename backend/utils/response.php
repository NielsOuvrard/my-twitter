<?php

// Function to send a JSON response
function jsonResponse($data, $status = 200) {
    // Set response headers
    header("Content-Type: application/json; charset=UTF-8");
    http_response_code($status);

    // Send JSON-encoded response
    echo json_encode($data);
}

// Function to send a 404 Not Found response
function notFoundResponse() {
    // Set response headers
    header("Content-Type: application/json; charset=UTF-8");
    http_response_code(404);

    // Send JSON-encoded error response
    echo json_encode(array('error' => 'Not Found'));
}

function errorResponse($message, $status = 400) {
    // Set response headers
    header("Content-Type: application/json; charset=UTF-8");
    http_response_code($status);

    // Send JSON-encoded error response
    echo json_encode(array('error' => $message));
}

function createdResponse($message) {
    // Set response headers
    header("Content-Type: application/json; charset=UTF-8");
    http_response_code(201);

    // Send JSON-encoded response
    echo json_encode(array('message' => $message));
}

function serverErrorResponse($message) {
    // Set response headers
    header("Content-Type: application/json; charset=UTF-8");
    http_response_code(500);

    // Send JSON-encoded error response
    echo json_encode(array('error' => $message));
}