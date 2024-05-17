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
        errorResponse("Connection to database failed: catch " . $servername . " " . $e->getMessage(), 500);
        die();
    }
    if (!$conn) {
        errorResponse("Connection to database failed: uncatch $servername",500);
        die();
    }
    
    return $conn;
}
