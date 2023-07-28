<?php
require_once(__DIR__ . "/autoload.php");
$request = $_SERVER['REQUEST_URI'];
switch ($request) {
    case '/':
        require_once(__DIR__ . "/resources/views/index.php");
        break;
    case '/register':
        require_once(__DIR__ . "/resources/views/validation.php");
        break;
    default:
        http_response_code(400);
        break;
}
