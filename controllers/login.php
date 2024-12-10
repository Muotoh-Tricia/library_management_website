<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Debug: Print received credentials
    error_log("Login attempt - Username: " . $username);

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // For testing purposes, print the password hash
        error_log("Stored password hash: " . $user['password']);
        error_log("User role: " . $user['role']);
        
        // For admin123, use direct comparison temporarily
        if ($user['role'] === 'admin' && $password === 'admin123') {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = 'admin';
            
            error_log("Admin login successful");
            header('Location: /Cohort-PHP-Assignments/LMS/views/admin/dashboard.php');
            exit();
        }
        // For regular users, use password_verify
        elseif (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            
            error_log("User login successful");
            header('Location: /Cohort-PHP-Assignments/LMS/views/books/browse.php');
            exit();
        } else {
            error_log("Password verification failed");
            header('Location: /Cohort-PHP-Assignments/LMS/views/users/login.php?error=invalid');
        }
    } else {
        error_log("User not found");
        header('Location: /Cohort-PHP-Assignments/LMS/views/users/login.php?error=notfound');
    }
    exit();
}
