<?php
require_once '../config/database.php';

class UserController {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function register($username, $email, $password) {
        $username = mysqli_real_escape_string($this->conn, $username);
        $email = mysqli_real_escape_string($this->conn, $email);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO users (username, email, password) 
                 VALUES ('$username', '$email', '$hashed_password')";
                 
        return mysqli_query($this->conn, $query);
    }

    public function login($email, $password) {
        $email = mysqli_real_escape_string($this->conn, $email);
        
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($this->conn, $query);
        
        if ($user = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                
                if ($user['role'] === 'admin') {
                    header('Location: /Cohort-PHP-Assignments/LMS/views/admin/dashboard.php');
                } else {
                    header('Location: /Cohort-PHP-Assignments/LMS/views/users/dashboard.php');
                }
                exit();
            } else {
                $_SESSION['error'] = "Invalid password";
            }
        } else {
            $_SESSION['error'] = "User not found";
        }
        
        header('Location: /Cohort-PHP-Assignments/LMS/views/users/login.php');
        exit();
    }

    public function handleLoginRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $this->login($email, $password);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $controller = new UserController();
    
    switch($_POST['action']) {
        case 'login':
            $controller->login($_POST['email'], $_POST['password']);
            break;
    }
}
?>
