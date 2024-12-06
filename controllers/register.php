<?php
session_start();
require '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if username or email already exists
    $check_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $_SESSION['error'] = "Username or email already exists!";
        header('Location: /Cohort-PHP-Assignments/LMS/views/users/register.php');
        exit();
    } else {
        $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

        if (mysqli_query($conn, $query)) {
            $_SESSION['success'] = "Registration successful! Please login.";
            header('Location: /Cohort-PHP-Assignments/LMS/views/users/login.php');
            exit();
        } else {
            $_SESSION['error'] = "Registration failed. Please try again.";
            header('Location: /Cohort-PHP-Assignments/LMS/views/users/register.php');
            exit();
        }
    }
}
