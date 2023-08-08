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

use app\controllers\Main;
use core\routes\Request;
use core\routes\Routing;

$router = new Routing(new Request);

$router->get('/', function () {
    (new Main)->index();
});

$router->get('/register', function () {
    (new Main)->register();
});

$router->get('/action', function () {
    (new Main)->action();
});
