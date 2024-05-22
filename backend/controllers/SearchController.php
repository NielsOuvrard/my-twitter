<?php

require_once ($base_path . 'utils' . DS . 'db.php');
require_once ($base_path . 'utils' . DS . 'response.php');
require_once ($base_path . 'utils' . DS . 'jwt.php');
require_once ($base_path . 'utils' . DS . 'tools.php'); // post data


class SearchController
{
    public static function getRoutes()
    {
        return [
            [
                'uri' => '/search/{word}',
                'method' => 'GET',
                'controller' => 'getSearch',
                'admin' => false,
                'auth' => false,
            ]
        ];
    }
    public static function getSearch() // check the word didnt contain '/'
    {
        $conn = connectDB();

        // Extract word from the request URI
        $uriSegments = explode('/', rtrim($_SERVER['REQUEST_URI'], '/'));
        $word = end($uriSegments);

        $request =
            "(SELECT id, username, email FROM users WHERE username LIKE '%?%')
        UNION
            (SELECT id, sender_id, content FROM messages WHERE content LIKE '%?%')
        UNION
            (SELECT id, user_id, content FROM publications WHERE content LIKE '%?%');";

        $stmt = $conn->prepare($request);

        $stmt->execute([$word, $word, $word]);
        $result = $stmt->fetchAll();

        jsonResponseOrError($result, 'No results found');
    }

}

