<?php
session_start();
require_once '/xampp/htdocs/Cohort-PHP-Assignments/LMS/config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to check user
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result && $user = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $user['password'])) {
            // Login successful
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect to browse page
            header('Location: /Cohort-PHP-Assignments/LMS/views/books/browse.php');
            exit();
        }
    }

    // Login failed
    $_SESSION['error'] = "Invalid username or password";
    header('Location: /Cohort-PHP-Assignments/LMS/views/users/login.php');
    exit();
}
