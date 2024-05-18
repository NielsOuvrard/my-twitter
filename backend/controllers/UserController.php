<?php

require_once ($base_path . 'utils' . DS . 'db.php');
require_once ($base_path . 'utils' . DS . 'response.php');
require_once ($base_path . 'utils' . DS . 'tools.php');


class UserController
{
    public static function getRoutes()
    {
        return [
            [
                'uri' => '/users',
                'method' => 'GET',
                'controller' => 'getAllUsers',
                'admin' => false,
                'auth' => false,
            ],
            [
                'uri' => '/users/{id}',
                'method' => 'GET',
                'controller' => 'getUserById',
                'admin' => false,
                'auth' => false,
            ],
            [
                'uri' => '/users',
                'method' => 'POST',
                'controller' => 'createUser',
                'admin' => false,
                'auth' => false,
            ],
            [
                'uri' => '/users/{id}',
                'method' => 'PUT',
                'controller' => 'updateUser',
                'admin' => false,
                'auth' => true,
            ],
            [
                'uri' => '/users/{id}',
                'method' => 'DELETE',
                'controller' => 'deleteUser',
                'admin' => true,
                'auth' => true,
            ],
            [
                'uri' => '/users',
                'method' => 'DELETE',
                'controller' => 'deleteOwnUser',
                'admin' => false,
                'auth' => true,
            ]
        ];
    }

    // Method to get all users
    public static function getAllUsers()
    {
        $conn = connectDB();
        // Execute the query
        $result = $conn->query("SELECT id, username, email FROM users");
        $users = $result->fetchAll();

        jsonResponseOrError($users, 'No users found');
    }

    // Method to get a user by ID
    public static function getUserById()
    {
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


        jsonResponseOrError($user, 'User not found');
    }

    public static function createUser()
    {
        $conn = connectDB();
        $data = getPostData();

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
            jsonResponse('User created successfully');
        } else {
            serverErrorResponse('User creation failed');
        }
    }

    public static function updateUser()
    {
        $conn = connectDB();
        $data = getPostData();

        // Extract user ID from the request URI
        $uriSegments = explode('/', rtrim($_SERVER['REQUEST_URI'], '/'));
        $userId = end($uriSegments);

        if (!is_numeric($userId)) {
            errorResponse('Invalid user ID');
            return;
        }

        // Check if the user exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();

        if (!$user) {
            errorResponse('User not found');
            return;
        }

        // Update the user
        $stmt = $conn->prepare("UPDATE users where id = ? SET username = ?, email = ?");
        if ($stmt->execute([$data['username'], $data['email'], $userId])) {
            jsonResponse('User updated successfully');
        } else {
            serverErrorResponse('User update failed');
        }
    }

    public static function deleteUser()
    {
        $conn = connectDB();

        // Extract user ID from the request URI
        $uriSegments = explode('/', rtrim($_SERVER['REQUEST_URI'], '/'));
        $userId = end($uriSegments);

        if (!is_numeric($userId)) {
            errorResponse('Invalid user ID');
            return;
        }

        // Check if the user exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();

        if (!$user) {
            errorResponse('User not found');
            return;
        }

        // Delete the user
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        if ($stmt->execute([$userId])) {
            jsonResponse('User deleted successfully');
        } else {
            serverErrorResponse('User deletion failed');
        }
    }

    public static function deleteOwnUser()
    {
        $conn = connectDB();
        $userId = $_SERVER['JWT_PAYLOAD']['user']['id'];

        if (!is_numeric($userId)) {
            errorResponse('Invalid user ID');
            return;
        }

        // Check if the user exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();

        if (!$user) {
            errorResponse('User not found');
            return;
        }

        // Delete the user
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        if ($stmt->execute([$userId])) {
            jsonResponse('User deleted successfully');
        } else {
            serverErrorResponse('User deletion failed');
        }
    }
}
