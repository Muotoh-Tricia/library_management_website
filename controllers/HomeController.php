<?php
class HomeController {
    public function index() {
        // If user is logged in, show books page
        if (isset($_SESSION['user_id'])) {
            header('Location: /Cohort-PHP-Assignments/LMS/views/books/browse.php');
            exit();
        }
        // Otherwise show landing page
        require_once '../views/layouts/landing.php';
    }
} 