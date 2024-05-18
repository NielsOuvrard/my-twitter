<?php

require_once ($base_path . 'utils' . DS . 'db.php');
require_once ($base_path . 'utils' . DS . 'response.php');
require_once ($base_path . 'utils' . DS . 'jwt.php');
require_once ($base_path . 'utils' . DS . 'tools.php'); // post data


class PublicationsController
{
    public static function getRoutes()
    {
        return [
            [
                'uri' => '/publications',
                'method' => 'GET',
                'controller' => 'getPublications',
                'admin' => false,
                'auth' => false,
            ],
            [
                'uri' => '/publications',
                'method' => 'POST',
                'controller' => 'createPublication',
                'admin' => false,
                'auth' => true,
            ],
            [
                'uri' => '/publications/{id}',
                'method' => 'DELETE',
                'controller' => 'deletePublications',
                'admin' => false,
                'auth' => true,
            ]
        ];

    }

    // todo: implement rule to get olders publications
    public static function getPublications()
    {
        $conn = connectDB();

        // get last 10 publications
        $stmt = $conn->prepare("SELECT * FROM publications ORDER BY id DESC LIMIT 10");
        $stmt->execute();
        $publications = $stmt->fetchAll();
        jsonResponseOrError($publications, 'No publications found');
    }

    public static function createPublication()
    {
        $data = getPostData();
        $conn = connectDB();

        $stmt = $conn->prepare("INSERT INTO publications (user_id, content) VALUES (?, ?)");
        $stmt->execute([$_SERVER['JWT_PAYLOAD']['user']['id'], $data['content']]);
        $publication_id = $conn->lastInsertId();
        jsonResponseOrError(['message' => 'Publication created', 'id' => $publication_id], 'Publication not created');
    }

    public static function deletePublications()
    {
        $conn = connectDB();
        // Extract user ID from the request URI
        $uriSegments = explode('/', rtrim($_SERVER['REQUEST_URI'], '/'));
        $pub_id = end($uriSegments);

        $stmt = $conn->prepare("DELETE FROM publications WHERE id = ?");
        $stmt->execute([$pub_id]); // TODO FROM URI
        jsonResponseOrError(['id' => $pub_id], 'Publication not deleted');
    }
}