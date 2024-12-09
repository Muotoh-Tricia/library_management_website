<?php
session_start();
require_once '/xampp/htdocs/Cohort-PHP-Assignments/LMS/config/database.php';
require_once '/xampp/htdocs/Cohort-PHP-Assignments/LMS/models/User.php';

class AuthController
{
    private $user;
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
        $this->user = new User($this->conn);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate input
            if (empty($_POST['username']) || empty($_POST['password'])) {
                $_SESSION['error'] = "Username and password are required";
                header('Location: /Cohort-PHP-Assignments/LMS/views/users/login.php');
                exit();
            }

            $user = $this->user->login($_POST['username'], $_POST['password']);

            if ($user) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'] ?? 'user';

                // Redirect to browse page after successful login
                header('Location: /Cohort-PHP-Assignments/LMS/views/books/browse.php');
                exit();
            } else {
                $_SESSION['error'] = "Invalid username or password";
                header('Location: /Cohort-PHP-Assignments/LMS/views/users/login.php');
                exit();
            }
        }
        require_once '/xampp/htdocs/Cohort-PHP-Assignments/LMS/views/users/login.php';
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate input
            if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
                $_SESSION['error'] = "All fields are required";
                header('Location: /Cohort-PHP-Assignments/LMS/views/users/register.php');
                exit();
            }

            if ($this->user->register($_POST)) {
                $_SESSION['success'] = "Registration successful! Please login.";
                header('Location: /Cohort-PHP-Assignments/LMS/views/users/login.php');
                exit();
            } else {
                $_SESSION['error'] = "Registration failed. Please try again.";
                header('Location: /Cohort-PHP-Assignments/LMS/views/users/register.php');
                exit();
            }
        }
        require_once '/xampp/htdocs/Cohort-PHP-Assignments/LMS/views/users/register.php';
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /Cohort-PHP-Assignments/LMS/views/users/login.php');
        exit();
    }
}
