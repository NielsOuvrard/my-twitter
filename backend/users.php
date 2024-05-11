<?php
// CREATE TABLE IF NOT EXISTS users (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     username VARCHAR(50) NOT NULL,
//     email VARCHAR(100) NOT NULL,
//     password VARCHAR(100) NOT NULL,
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
// );
// job
// bio

// Function to retrieve all users
function getUsers($conn) {
    $stmt = $conn->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // remove password field from the response
    foreach($users as $key => $user) {
        unset($users[$key]['password']);
        unset($users[$key]['created_at']);
    }
    echo json_encode($users);
}

// Function to retrieve a specific user by ID
function getUser($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if($user) {
        unset($user['password']);
        unset($user['created_at']);
        echo json_encode($user);
    } else {
        http_response_code(404); // Not Found
        echo json_encode(array("message" => "User not found"));
    }
}

// Function to create a new user
function createUser($conn, $data) {
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    if($stmt->execute([$data['username'], $data['email'], $data['password']])) {
        http_response_code(201); // Created
        echo json_encode(array("message" => "User created successfully"));
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(array("message" => "User creation failed"));
    }
}

// Function to update user information
function updateUser($conn, $id, $data) {
    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?");
    if($stmt->execute([$data['username'], $data['email'], $data['password'], $id])) {
        http_response_code(200); // OK
        echo json_encode(array("message" => "User updated successfully"));
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(array("message" => "User update failed"));
    }
}

// Function to delete user
function deleteUser($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    if($stmt->execute([$id])) {
        http_response_code(200); // OK
        echo json_encode(array("message" => "User deleted successfully"));
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(array("message" => "User deletion failed"));
    }
}

