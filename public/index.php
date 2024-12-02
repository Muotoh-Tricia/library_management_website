<?php
session_start();

require_once '../config/database.php';
require_once '../controllers/HomeController.php';
require_once '../controllers/BookController.php';
require_once '../controllers/UserController.php';
require_once '../controllers/AuthController.php';

// Default to home controller if no controller specified
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch($controller) {
    case 'home':
        $controller = new HomeController();
        break;
    case 'book':
        $controller = new BookController();
        break;
    case 'user':
        $controller = new UserController();
        break;
    case 'auth':
        $controller = new AuthController();
        break;
    default:
        $controller = new HomeController();
}

if(method_exists($controller, $action)) {
    $controller->$action();
} else {
    $controller->index();
}
