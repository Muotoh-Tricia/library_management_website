<?php
class HomeController {
    public function index() {
        // If user is logged in, show books page
        if (isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=book&action=index');
            exit();
        }
        // Otherwise show landing page
        require_once '../views/layouts/landing.php';
    }
} 