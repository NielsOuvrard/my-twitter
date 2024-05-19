<?php

require_once ($base_path . 'utils' . DS . 'db.php');
require_once ($base_path . 'utils' . DS . 'response.php');
require_once ($base_path . 'utils' . DS . 'jwt.php');
require_once ($base_path . 'utils' . DS . 'tools.php'); // post data


class MessagesController
{
    public static function getRoutes()
    {
        return [
            [
                'uri' => '/messages', // get most recent message from users (max 10 users)
                'method' => 'GET',
                'controller' => 'getLastUsersMessages',
                'admin' => false,
                'auth' => true,
            ],
            [
                'uri' => '/messages/{id}', // get messages from user with id
                'method' => 'GET',
                'controller' => 'getMessages',
                'admin' => false,
                'auth' => true,
            ],
            [
                'uri' => '/messages/{id}', // send message to user with id
                'method' => 'POST',
                'controller' => 'createMessage',
                'admin' => false,
                'auth' => true,
            ],
            [
                'uri' => '/messages/{id}',
                'method' => 'DELETE',
                'controller' => 'deleteMessage',
                'admin' => false,
                'auth' => true,
            ]
        ];
    }
    public static function getLastUsersMessages()
    {
        $user_id = $_SERVER['JWT_PAYLOAD']['user']['id'];
        $conn = connectDB();

        $request =
            "SELECT 
                m.id AS message_id,
                m.content,
                m.created_at,
                sender.id AS sender_id,
                sender.username AS sender_username,
                sender.email AS sender_email,
                recipient.id AS recipient_id,
                recipient.username AS recipient_username,
                recipient.email AS recipient_email
            FROM 
                messages m
            INNER JOIN 
                users sender ON m.sender_id = sender.id
            INNER JOIN 
                users recipient ON m.recipient_id = recipient.id
            INNER JOIN (
                SELECT 
                    GREATEST(sender_id, recipient_id) AS user1,
                    LEAST(sender_id, recipient_id) AS user2,
                    MAX(created_at) AS last_message_time
                FROM 
                    messages
                GROUP BY 
                    GREATEST(sender_id, recipient_id),
                    LEAST(sender_id, recipient_id)
            ) AS last_messages ON 
                (m.sender_id = last_messages.user1 AND m.recipient_id = last_messages.user2 AND m.created_at = last_messages.last_message_time) 
                OR 
                (m.sender_id = last_messages.user2 AND m.recipient_id = last_messages.user1 AND m.created_at = last_messages.last_message_time)
            WHERE 
                m.sender_id = ? OR m.recipient_id = ?
            ORDER BY 
                m.created_at DESC;";

        $stmt = $conn->prepare($request);

        $stmt->execute([$user_id, $user_id]);
        $messages = [];
        while ($row = $stmt->fetch()) {
            $other = $row['sender_id'] == $user_id ? 'recipient' : 'sender';
            $messages[] = [
                'message_id' => $row['message_id'],
                'content' => $row['content'],
                'created_at' => $row['created_at'],
                'user' => [
                    'id' => $row[$other . '_id'],
                    'username' => $row[$other . '_username'],
                    'email' => $row[$other . '_email']
                ]
            ];
        }

        jsonResponseOrError($messages, 'No messages found');
    }

    // todoImplement rule to get olders messages
    public static function getMessages()
    {
        $user_id = $_SERVER['JWT_PAYLOAD']['user']['id'];
        $conn = connectDB();
        // Extract user ID from the request URI
        $uriSegments = explode('/', rtrim($_SERVER['REQUEST_URI'], '/'));
        $sender_id = end($uriSegments);

        $request = "SELECT * FROM messages WHERE (recipient_id = ? and sender_id = ?) OR (recipient_id = ? and sender_id = ?) ORDER BY created_at ASC LIMIT 10;";

        // get last 10 messages
        $stmt = $conn->prepare($request);
        $stmt->execute([$user_id, $sender_id, $sender_id, $user_id]);
        $messages = $stmt->fetchAll();
        jsonResponseOrError($messages, 'No messages found');
    }

    public static function createMessage()
    {
        $data = getPostData();
        $conn = connectDB();
        // Extract user ID from the request URI
        $uriSegments = explode('/', rtrim($_SERVER['REQUEST_URI'], '/'));
        $recipient_id = end($uriSegments);

        $stmt = $conn->prepare("INSERT INTO messages (sender_id, recipient_id, content) VALUES (?, ?, ?)");
        $stmt->execute([$_SERVER['JWT_PAYLOAD']['user']['id'], $recipient_id, $data['message']]);
        $message_id = $conn->lastInsertId();
        jsonResponseOrError(['message' => 'Message sent', 'id' => $message_id], 'Message not sent');
    }

    public static function deleteMessage()
    {
        $conn = connectDB();
        // Extract user ID from the request URI
        $uriSegments = explode('/', rtrim($_SERVER['REQUEST_URI'], '/'));
        $message_id = end($uriSegments);

        $stmt = $conn->prepare("DELETE FROM messages WHERE id = ?");
        $stmt->execute([$message_id]);
        jsonResponseOrError(['message' => 'Message deleted', 'id' => $message_id], 'Message not deleted');
    }
}