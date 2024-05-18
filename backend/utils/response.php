<?php

// Function to send a JSON response
function jsonResponse($data, $status = 200)
{
    // Set response headers
    header("Content-Type: application/json; charset=UTF-8");
    http_response_code($status);

    // Send JSON-encoded response
    echo json_encode($data);
}

function errorResponse($message, $status = 400)
{
    // Set response headers
    header("Content-Type: application/json; charset=UTF-8");
    http_response_code($status);

    // Send JSON-encoded error response
    echo json_encode(array('error' => $message));
}

function serverErrorResponse($message)
{
    // Set response headers
    header("Content-Type: application/json; charset=UTF-8");
    http_response_code(500);

    // Send JSON-encoded error response
    echo json_encode(array('error' => $message));
}


function jsonResponseOrError($data, $error, $status = 200)
{
    if ($data) {
        jsonResponse($data, $status);
    } else {
        errorResponse($error);
    }
}
