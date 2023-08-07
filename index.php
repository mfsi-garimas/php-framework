<?php
require_once(__DIR__ . "/autoload.php");
$request = $_SERVER['REQUEST_URI'];
// switch ($request) {
//     case '/':
//         require_once(__DIR__ . "/resources/views/index.php");
//         break;
//     case '/register':
//         require_once(__DIR__ . "/resources/views/validation.php");
//         break;
//     case '/action':
//         require_once(__DIR__ . "/resources/views/action.php");
//         break;
//     default:
//         http_response_code(400);
//         break;
// }

require_once './core/routes/Request.php';
require_once './core/routes/Routing.php';
$router = new Routing(new Request);

$router->get('/', function () {
    require_once(__DIR__ . "/resources/views/index.php");
});

$router->get('/register', function () {
    require_once(__DIR__ . "/resources/views/validation.php");
});

$router->get('/action', function () {
    require_once(__DIR__ . "/resources/views/action.php");
});
