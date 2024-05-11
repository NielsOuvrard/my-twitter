<?php
// CREATE TABLE IF NOT EXISTS relationships (
//     user1_id INT NOT NULL,
//     user2_id INT NOT NULL,
//     status ENUM('pending', 'accepted') DEFAULT 'pending',
//     PRIMARY KEY (user1_id, user2_id),
//     FOREIGN KEY (user1_id) REFERENCES users(id),
//     FOREIGN KEY (user2_id) REFERENCES users(id)
// );

// Function to retrieve all relationships
function getRelationships($conn) {
    $stmt = $conn->query("SELECT * FROM relationships");
    $relationships = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($relationships);
}

// Function to retrieve all relationships of a specific user
function getUserRelationships($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM relationships WHERE user1_id = ? OR user2_id = ?");
    $stmt->execute([$id, $id]);
    $relationships = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($relationships);
}

// Function to create a new relationship
function createRelationship($conn, $data) {
    $stmt = $conn->prepare("INSERT INTO relationships (user1_id, user2_id) VALUES (?, ?)");
    if($stmt->execute([$data['user1_id'], $data['user2_id']])) {
        http_response_code(201); // Created
        echo json_encode(array("message" => "Relationship created successfully"));
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(array("message" => "Relationship creation failed"));
    }
}

// Function to update relationship status
function updateRelationship($conn, $user1_id, $user2_id, $status) {
    $stmt = $conn->prepare("UPDATE relationships SET status = ? WHERE user1_id = ? AND user2_id = ?");
    if($stmt->execute([$status, $user1_id, $user2_id])) {
        http_response_code(200); // OK
        echo json_encode(array("message" => "Relationship updated successfully"));
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(array("message" => "Relationship update failed"));
    }
}

// Function to delete relationship
function deleteRelationship($conn, $user1_id, $user2_id) {
    $stmt = $conn->prepare("DELETE FROM relationships WHERE user1_id = ? AND user2_id = ?");
    if($stmt->execute([$user1_id, $user2_id])) {
        http_response_code(200); // OK
        echo json_encode(array("message" => "Relationship deleted successfully"));
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(array("message" => "Relationship deletion failed"));
    }
}

