<?php

require_once($base_path . 'utils' . DS . 'db.php');
require_once($base_path . 'utils' . DS . 'response.php');


class UserController {
    public static function json_or_error($data) {
        if ($data) {
            jsonResponse($data);
        } else {
            notFoundResponse();
        }
    }

    
    // Method to get all users
    public static function getAllUsers() {
        $conn = connectDB();
        // Execute the query
        $result = $conn->query("SELECT id, username, email FROM users");
        $users = $result->fetchAll();

        UserController::json_or_error($users);
    }
    
    // Method to get a user by ID
    public static function getUserById() {
        $conn = connectDB();
        // Extract user ID from the request URI
        $uriSegments = explode('/', rtrim($_SERVER['REQUEST_URI'], '/'));
        $userId = end($uriSegments);
        
        if (!is_numeric($userId)) {
            errorResponse('Invalid user ID');
            return;
        }
        
        $stmt = $conn->prepare("SELECT id, username, email FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();


        UserController::json_or_error($user);
    }

    public static function getUserByEmail($email) {
        $conn = connectDB();
        $stmt = $conn->prepare("SELECT id, username, email FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();


        UserController::json_or_error($user);
    }

    public static function createUser() {
        $conn = connectDB();
        // Get the request data
        $data = json_decode(file_get_contents('php://input'), true);

        // Check if the required fields are provided
        if (!isset($data['username']) || !isset($data['email']) || !isset($data['password'])) {
            errorResponse('Please provide username, email, and password');
            return;
        }

        // Check if the email is already registered
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$data['email']]);
        $user = $stmt->fetch();

        if ($user) {
            errorResponse('Email already registered');
            return;
        }

        // Hash the password
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        // Insert the user into the database
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        if ($stmt->execute([$data['username'], $data['email'], $hashedPassword])) {
            createdResponse('User created successfully');
        } else {
            serverErrorResponse('User creation failed');
        }
    }
}
