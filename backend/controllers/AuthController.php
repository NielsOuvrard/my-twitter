<?php

require_once($base_path . 'utils' . DS . 'db.php');
require_once($base_path . 'utils' . DS . 'response.php');
require_once($base_path . 'utils' . DS . 'jwt.php');


class AuthController {

    public static function json_or_error($data) {
        if ($data) {
            jsonResponse($data);
        } else {
            notFoundResponse();
        }
    }

    public static function login() {
        $data = $_POST;

        // Check if the request body is empty
        if (empty($data)) {
            errorResponse('Request body empty');
            return;
        }
        
        // Check if the email and password are provided
        if (!isset($data['email']) || !isset($data['password'])) {
            errorResponse('Email and password are required');
            return;
        }
        
        $conn = connectDB();
        // Extract email and password from the request body
        $email = $data['email'];
        $password = $data['password'];

        // Prepare the SQL query to fetch the user with the given email
        $stmt = $conn->prepare("SELECT id, username, email, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // Check if a user with the given email exists
        if (!$user) {
            errorResponse('User not found');
            return;
        }

        // Check if the password is correct
        if (!password_verify($password, $user['password'])) {
            errorResponse('Incorrect password');
            return;
        }

        // Generate a JWT token
        $header = ["alg" => "HS256", "typ" => "JWT"];
        $payload = $user;
        $secret = getenv('JWT_SECRET_KEY');

        $jwt = new JWT();
        $token = $jwt->generate($header, $payload, $secret);

        // Send the token in the response
        jsonResponse(['token' => $token]);
    }

    public static function register() {
        $data = $_POST;

        // Check if the request body is empty
        if (empty($data)) {
            errorResponse('Request body empty');
            return;
        }
        
        // Check if the required fields are provided
        if (!isset($data['username']) || !isset($data['email']) || !isset($data['password'])) {
            errorResponse('Please provide username, email, and password');
            return;
        }
        
        $conn = connectDB();
        // Extract username, email, and password from the request body
        $username = $data['username'];
        $email = $data['email'];
        $password = $data['password'];

        // Check if a user with the given email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            errorResponse('User with the given email already exists');
            return;
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the SQL query to insert the new user
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        if ($stmt->execute([$username, $email, $hashedPassword])) {
            createdResponse('User created successfully');
        } else {
            serverErrorResponse('User creation failed');
        }
    }

    public static function logout() {
        // Check if the Authorization header is present
        if (!isset($_SERVER['HTTP_AUTHORIZATION'])) { // not sure
            errorResponse('Authorization header is missing', 401);
            return;
        }
        
        // Extract the token from the Authorization header
        $token = $_SERVER['HTTP_AUTHORIZATION'];

        // Verify the token
        $jwt = new JWT();
        $secret = getenv('JWT_SECRET_KEY');

        if (!$jwt->check($token, $secret)) {
            errorResponse('Invalid token', 401);
            return;
        }

        // Send a success response
        jsonResponse(['message' => 'Logged out successfully']);
    }
}