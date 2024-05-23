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

        // remove, by security, all characters that are not letters or numbers
        $word = preg_replace('/[^a-zA-Z0-9]/', '', $word);

        // remove the messages in the future to avoid private messages in the search
        $request =
            "(SELECT id, email AS result, 'user' AS kind FROM users WHERE username LIKE '%$word%')
        UNION
            (SELECT id, content AS result, 'messages' AS kind FROM messages WHERE content LIKE '%$word%')
        UNION
            (SELECT id, content AS result, 'publications' AS kind FROM publications WHERE content LIKE '%$word%');";

        $stmt = $conn->prepare($request);
        $stmt->execute();
        $result = $stmt->fetchAll();

        jsonResponseOrError($result, 'No results found');
    }

}

