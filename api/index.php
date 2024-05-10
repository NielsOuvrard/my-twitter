<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

$servername = getenv('DB_SERVERNAME');
$username = getenv('DB_USERNAME');
$password = getenv('DB_PASSWORD');
$dbname = 'users';
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// Establishing connection to the database
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, $opt);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// API endpoints
switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Retrieve user(s) information
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            getUser($conn, $id);
        } else {
            getUsers($conn);
        }
        break;
    case 'POST':
        // Create a new user
        $data = json_decode(file_get_contents('php://input'), true);
        createUser($conn, $data);
        break;
    case 'PUT':
        // Update user information
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $_GET['id'];
        updateUser($conn, $id, $data);
        break;
    case 'DELETE':
        // Delete user
        $id = $_GET['id'];
        deleteUser($conn, $id);
        break;
    default:
        http_response_code(405); // Method Not Allowed
        echo json_encode(array("message" => "Method Not Allowed"));
}

// Function to retrieve all users
function getUsers($conn) {
    $stmt = $conn->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // remove password field from the response
    foreach($users as $key => $user) {
        unset($users[$key]['password']);
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


?>
