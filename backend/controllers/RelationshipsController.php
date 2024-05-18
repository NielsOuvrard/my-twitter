<?php

require_once ($base_path . 'utils' . DS . 'db.php');
require_once ($base_path . 'utils' . DS . 'response.php');
require_once ($base_path . 'utils' . DS . 'tools.php');


class RelationshipsController
{
    public static function getRoutes()
    {
        return [
            [
                'uri' => '/relationships',
                'method' => 'GET',
                'controller' => 'getRelationships',
                'admin' => false,
                'auth' => true,
            ],
            [
                'uri' => '/relationships',
                'method' => 'POST',
                'controller' => 'createRelationship',
                'admin' => false,
                'auth' => true,
            ],
            [
                'uri' => '/relationships/{id}',
                'method' => 'DELETE',
                'controller' => 'deleteRelationship',
                'admin' => false,
                'auth' => true,
            ]
        ];
    }

    public static function getRelationships()
    {
        $conn = connectDB();

        $stmt = $conn->prepare("SELECT * FROM relationships WHERE user_id = ?");
        $stmt->execute([$_SERVER['JWT_PAYLOAD']['user']['id']]);
        $relationships = $stmt->fetchAll();
        jsonResponseOrError($relationships, 'No relationships found');
    }

    public static function createRelationship()
    {
        $conn = connectDB();
        $data = getPostData();

        $stmt = $conn->prepare("INSERT INTO relationships (user_id, friend_id) VALUES (?, ?)");
        $stmt->execute([$_SERVER['JWT_PAYLOAD']['user']['id'], $data['friend_id']]);
        $relationship_id = $conn->lastInsertId();
        jsonResponseOrError(['id' => $relationship_id], 'Relationship not created');
    }

    public static function deleteRelationship()
    {
        // Extract user ID from the request URI
        $uriSegments = explode('/', rtrim($_SERVER['REQUEST_URI'], '/'));
        $rel_id = end($uriSegments);

        $conn = connectDB();
        $stmt = $conn->prepare("DELETE FROM relationships WHERE user_id = ? AND id = ?");
        $stmt->execute([$_SERVER['JWT_PAYLOAD']['user']['id'], $rel_id]);
        jsonResponseOrError(['deleted relation id' => $rel_id], 'Relationship not deleted'); // todo message with name of the friend
    }
}
