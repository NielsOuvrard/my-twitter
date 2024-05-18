<?php

function getPostData()
{
    if ($_SERVER["CONTENT_TYPE"] === "application/json") {
        return json_decode(file_get_contents('php://input'), true);
    } else {
        return $_POST;
    }
}