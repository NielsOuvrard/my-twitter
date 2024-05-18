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

    // todo: implement rule to get olders messages
    public static function getMessages()
    {
        $conn = connectDB();
        // Extract user ID from the request URI
        $uriSegments = explode('/', rtrim($_SERVER['REQUEST_URI'], '/'));
        $sender_id = end($uriSegments);

        // get last 10 messages
        $stmt = $conn->prepare("SELECT * FROM messages WHERE (recipient_id = ? and sender_id = ?) OR (recipient_id = ? and sender_id = ?) ORDER BY id DESC LIMIT 10");
        $stmt->execute([$_SERVER['JWT_PAYLOAD']['user']['id'], $sender_id, $sender_id, $_SERVER['JWT_PAYLOAD']['user']['id']]);
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