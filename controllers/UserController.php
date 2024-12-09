<?php
require_once '../models/User.php';

class UserController {
    private $user;
    private $db;

    // public function __construct() {
    //     $database = new Database();
    //     $this->db = $database->connect();
    //     $this->user = new User($this->db);
    // }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->user->register($_POST)) {
                header('Location: /Cohort-PHP-Assignments/LMS/views/users/login.php');
                exit();
            }
        }
        require_once '../views/users/register.php';
    }

    public function profile() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /Cohort-PHP-Assignments/LMS/views/users/login.php');
            exit();
        }

        // Get user's borrowing history
        $query = "SELECT b.*, books.title 
                 FROM borrowings b 
                 JOIN books ON b.book_id = books.id 
                 WHERE b.user_id = " . $_SESSION['user_id'] . " 
                 ORDER BY b.borrow_date DESC";
        $borrowings = mysqli_query($this->db, $query);

        require_once '../views/users/profile.php';
    }

    public function updateProfile() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /Cohort-PHP-Assignments/LMS/views/users/login.php');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = mysqli_real_escape_string($this->db, $_POST['username']);
            $email = mysqli_real_escape_string($this->db, $_POST['email']);
            $new_password = $_POST['new_password'];
            $current_password = $_POST['current_password'];

            // Verify current password
            if ($this->user->verifyPassword($_SESSION['user_id'], $current_password)) {
                $update_result = $this->user->updateProfile($_SESSION['user_id'], [
                    'username' => $username,
                    'email' => $email,
                    'new_password' => $new_password
                ]);

                if ($update_result) {
                    $_SESSION['username'] = $username;
                    $_SESSION['email'] = $email;
                    $_SESSION['message'] = "Profile updated successfully!";
                } else {
                    $_SESSION['message'] = "Error updating profile.";
                }
            } else {
                $_SESSION['message'] = "Current password is incorrect.";
            }
        }

        header('Location: /Cohort-PHP-Assignments/LMS/views/users/profile.php');
        exit();
    }
}
