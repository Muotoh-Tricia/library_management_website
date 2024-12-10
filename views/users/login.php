<?php

session_start();

include '/xampp/htdocs/Cohort-PHP-Assignments/LMS/templates/header.php';

require_once '../../config/database.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="text-center mb-4">
                    <h2 class="text-success fw-bold">Welcome Back!</h2>
                    <p class="text-muted">Please login to your account</p>
                </div>

                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-body p-5">
                        <?php if (isset($_GET['error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php
                                if ($_GET['error'] == 'invalid') {
                                    echo "Invalid username or password!";
                                } elseif ($_GET['error'] == 'notfound') {
                                    echo "User not found!";
                                }
                                ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="../../controllers/login.php">
                            <div class="mb-4">
                                <label class="form-label small fw-bold">Username</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-white text-success">
                                        <i class="bi bi-person-fill"></i>
                                    </span>
                                    <input type="text" class="form-control" name="username" required
                                        placeholder="Enter your username">
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label class="form-label small fw-bold">Password</label>
                                    <a href="#" class="text-success text-decoration-none small">Forgot Password?</a>
                                </div>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-white text-success">
                                        <i class="bi bi-lock-fill"></i>
                                    </span>
                                    <input type="password" class="form-control" name="password" required
                                        placeholder="Enter your password">
                                </div>
                            </div>

                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-success btn-lg">
                                    Sign In
                                </button>
                            </div>

                            <div class="text-center">
                                <span class="text-muted">Don't have an account?</span>
                                <a href="/Cohort-PHP-Assignments/LMS/views/users/register.php"
                                    class="text-success text-decoration-none fw-bold ms-1">
                                    Create one
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .card {
            transition: transform 0.3s ease;
            border-radius: 15px;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .input-group-text {
            border: none;
            border-right: 1px solid #ced4da;
        }

        .form-control {
            border-left: none;
            padding-left: 0;
        }

        .form-control:focus {
            border-color: #198754;
            box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.1);
        }

        .btn-success {
            background: linear-gradient(45deg, #198754, #20c997);
            border: none;
            padding: 12px;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(25, 135, 84, 0.3);
            background: linear-gradient(45deg, #20c997, #198754);
        }

        .alert {
            border-radius: 10px;
            border: none;
        }

        .alert-dismissible .btn-close {
            padding: 0.9rem;
        }

        .input-group-lg>.form-control,
        .input-group-lg>.input-group-text {
            border-radius: 10px;
        }

        .input-group> :not(:first-child) {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        .input-group> :not(:last-child) {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }
    </style>
</body>

</html>