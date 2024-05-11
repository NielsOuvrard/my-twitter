<?php



// -- Create the messages table
// CREATE TABLE IF NOT EXISTS messages (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     sender_id INT NOT NULL,
//     recipient_id INT NOT NULL,
//     message TEXT NOT NULL,
//     sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//     FOREIGN KEY (sender_id) REFERENCES users(id),
//     FOREIGN KEY (recipient_id) REFERENCES users(id)
// );

// Function to retrieve all messages
function getMessages($conn) {
    $stmt = $conn->query("SELECT * FROM messages");
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($messages);
}

// Function to retrieve all messages between two users
function getUserMessages($conn, $user1_id, $user2_id) {
    $stmt = $conn->prepare("SELECT * FROM messages WHERE (sender_id = ? AND recipient_id = ?) OR (sender_id = ? AND recipient_id = ?)");
    $stmt->execute([$user1_id, $user2_id, $user2_id, $user1_id]);
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($messages);
}

// Function to create a new message
function createMessage($conn, $data) {
    $stmt = $conn->prepare("INSERT INTO messages (sender_id, recipient_id, message) VALUES (?, ?, ?)");
    if($stmt->execute([$data['sender_id'], $data['recipient_id'], $data['message']])) {
        http_response_code(201); // Created
        echo json_encode(array("message" => "Message created successfully"));
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(array("message" => "Message creation failed"));
    }
}

// Function to delete message
function deleteMessage($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM messages WHERE id = ?");
    if($stmt->execute([$id])) {
        http_response_code(200); // OK
        echo json_encode(array("message" => "Message deleted successfully"));
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(array("message" => "Message deletion failed"));
    }
}
