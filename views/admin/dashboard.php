<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard - Library Management System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
    <!-- Custom styles -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Strict role check for admin access
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        // Debug: Print session data
        error_log("Unauthorized access attempt - Role: " . ($_SESSION['role'] ?? 'none'));
        header('Location: /Cohort-PHP-Assignments/LMS/views/users/login.php?error=unauthorized');
        exit();
    }

    require_once('/xampp/htdocs/Cohort-PHP-Assignments/LMS/templates/header.php');
    require_once('/xampp/htdocs/Cohort-PHP-Assignments/LMS/controllers/AdminController.php');

    $admin = new AdminController();
    ?>

    <div class="container py-4">
        <!-- Statistics Cards with Professional Styling -->
        <div class="row g-4 mb-5">
            <!-- Total Books Card -->
            <div class="col-md-4">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-body p-4 bg-gradient" style="background-color: #4e73df;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white text-uppercase mb-2">
                                    <i class="bi bi-book me-2"></i>Total Books
                                </h6>
                                <h2 class="display-5 text-white mb-0 fw-bold">
                                    <?php echo $admin->getTotalBooks(); ?>
                                </h2>
                            </div>
                            <div class="icon-circle bg-white bg-opacity-25 rounded-circle p-4">
                                <i class="bi bi-book-half text-white fs-1"></i>
                            </div>
                        </div>
                        <div class="progress mt-4 bg-white bg-opacity-25" style="height: 4px;">
                            <div class="progress-bar bg-white" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Books Issued Card -->
            <div class="col-md-4">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-body p-4 bg-gradient" style="background-color: #1cc88a;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white text-uppercase mb-2">
                                    <i class="bi bi-journal-check me-2"></i>Books Issued
                                </h6>
                                <h2 class="display-5 text-white mb-0 fw-bold">
                                    <?php echo $admin->getBorrowedBooks(); ?>
                                </h2>
                            </div>
                            <div class="icon-circle bg-white bg-opacity-25 rounded-circle p-4">
                                <i class="bi bi-journal-arrow-up text-white fs-1"></i>
                            </div>
                        </div>
                        <div class="progress mt-4 bg-white bg-opacity-25" style="height: 4px;">
                            <div class="progress-bar bg-white" style="width: 75%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Overdue Books Card -->
            <div class="col-md-4">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-body p-4 bg-gradient" style="background-color: #e74a3b;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white text-uppercase mb-2">
                                    <i class="bi bi-exclamation-triangle me-2"></i>Overdue Books
                                </h6>
                                <h2 class="display-5 text-white mb-0 fw-bold">
                                    <?php echo $admin->getOverdueBooks(); ?>
                                </h2>
                            </div>
                            <div class="icon-circle bg-white bg-opacity-25 rounded-circle p-4">
                                <i class="bi bi-clock-history text-white fs-1"></i>
                            </div>
                        </div>
                        <div class="progress mt-4 bg-white bg-opacity-25" style="height: 4px;">
                            <div class="progress-bar bg-white" style="width: 50%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <button class="btn btn-success me-2 hover-card" data-bs-toggle="modal" data-bs-target="#addBookModal">
                <i class="bi bi-plus-lg me-2"></i>Add New Book
            </button>
            <a href="transaction_history.php" class="btn btn-success hover-card">
                <i class="bi bi-clock-history me-2"></i>View Transaction History
            </a>
        </div>
    </div>

    <!-- Books Management Table -->
    <div class="card border-success shadow-sm">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Manage Books</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>ISBN</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $books = $admin->getAllBooks();
                        while ($book = mysqli_fetch_assoc($books)):
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($book['title']); ?></td>
                                <td><?php echo htmlspecialchars($book['author']); ?></td>
                                <td><?php echo htmlspecialchars($book['isbn']); ?></td>
                                <td>
                                    <span class="badge <?php echo $book['status'] === 'available' ? 'bg-success' : 'bg-warning'; ?>">
                                        <?php echo ucfirst($book['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-success me-1"
                                        onclick="editBook(<?php echo $book['id']; ?>)">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger"
                                        onclick="deleteBook(<?php echo $book['id']; ?>)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

    <?php include '../../templates/footer.php'; ?>

    <style>
        .hover-card {
            transition: all 0.3s ease;
        }

        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .card {
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .icon-circle {
            height: 60px;
            width: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .bg-gradient {
            background-image: linear-gradient(180deg, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 100%);
        }

        /* Responsive font sizes */
        @media (max-width: 768px) {
            .display-5 {
                font-size: 2rem;
            }
            .icon-circle {
                height: 50px;
                width: 50px;
            }
            .fs-1 {
                font-size: 1.5rem !important;
            }
        }
    </style>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>