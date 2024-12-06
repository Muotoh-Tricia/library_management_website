<?php
session_start();

require_once '../config/database.php';
require_once '../controllers/HomeController.php';
require_once '../controllers/BookController.php';
require_once '../controllers/UserController.php';
require_once '../controllers/AuthController.php';

// Get controller and action from URL parameters
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Instantiate the appropriate controller
switch ($controller) {
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

// Call the action method if it exists
if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    // Handle invalid action
    echo "Error: Action not found.";
}
