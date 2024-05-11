<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

const DS = DIRECTORY_SEPARATOR;

$base_path = realpath(dirname(__FILE__)) . DS;

require_once($base_path . 'utils' . DS . 'jwt.php');

require_once('routes/routes.php');
