<?php

function connectDB() {
    $servername = getenv('DB_SERVERNAME');
    $username = getenv('DB_USERNAME');
    $password = getenv('DB_PASSWORD');
    $dbname = 'db';
    $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, $opt);
    } catch(PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    return $conn;
}