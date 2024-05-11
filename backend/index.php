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

include 'users.php';
include 'relationships.php';
include 'messages.php';

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

// -- Create the posts table
// CREATE TABLE IF NOT EXISTS posts (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     user_id INT NOT NULL,
//     content TEXT NOT NULL,
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//     FOREIGN KEY (user_id) REFERENCES users(id)
// );


?>
