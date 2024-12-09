<!DOCTYPE html>
<html>

<head>
    <title>Welcome to Library Management System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include '/xampp/htdocs/Cohort-PHP-Assignments/LMS/templates/header.php'; ?>

    <!-- Hero Section -->
    <div class="bg-light py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 text-center text-lg-start">
                    <h1 class="display-4 fw-bold text-success mb-4">Welcome to Our Library</h1>
                    <p class="lead mb-4">Your Gateway to Knowledge</p>
                    <a href="/Cohort-PHP-Assignments/LMS/views/users/login.php" class="btn btn-success btn-lg px-4">Get
                        Started</a>
                </div>
                <div class="col-lg-6">
                    <img src="../../assets/book.jpg" class="img-fluid rounded" alt="Library">
                </div>
            </div>
        </div>
    </div>

    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="container py-5">
            <div class="row mb-4">
                <div class="col">
                    <h2 class="text-success">My Borrowed Books</h2>
                </div>
            </div>

            <div class="row g-4">
                <?php
                $user_id = $_SESSION['user_id'];
                $query = "SELECT books.*, borrowings.return_date 
                     FROM borrowings 
                     JOIN books ON books.id = borrowings.book_id 
                     WHERE borrowings.user_id = $user_id 
                     AND borrowings.status = 'borrowed'";
                $result = mysqli_query($conn, $query);

                while ($book = mysqli_fetch_assoc($result)):
                    ?>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="card h-100 border-success shadow-sm hover-shadow">
                            <img src="<?php echo $book['image_url']; ?>" class="card-img-top p-3" alt="Book Cover"
                                style="height: 200px; object-fit: cover;">

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-success">
                                    <?php echo $book['title']; ?>
                                </h5>

                                <p class="card-text text-muted mb-1">
                                    By <?php echo $book['author']; ?>
                                </p>

                                <div class="mt-auto">
                                    <p class="card-text small mb-0">
                                        <strong>Return Date:</strong><br>
                                        <span class="text-danger">
                                            <?php echo date('F j, Y', strtotime($book['return_date'])); ?>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>

                <?php if (mysqli_num_rows($result) == 0): ?>
                    <div class="col-12">
                        <div class="alert alert-success">
                            <i class="bi bi-info-circle me-2"></i>
                            You haven't borrowed any books yet.
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Features Section -->
    <div class="container py-5">
        <h2 class="text-center text-success mb-5">Our Features</h2>
        <div class="row g-4">
            <!-- Browse Books Card -->
            <div class="col-md-4">
                <a href="/Cohort-PHP-Assignments/LMS/views/books/browse.php" class="text-decoration-none">
                    <div class="card h-100 border-success hover-card">
                        <div class="card-body text-center">
                            <h3 class="card-title h4 text-success">Browse Books</h3>
                            <p class="card-text text-dark">Access our extensive collection</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Recommendation Card -->
            <div class="col-md-4">
                <a href="../views/books/borrow.php" class="text-decoration-none">
                    <div class="card h-100 border-success hover-card">
                        <div class="card-body text-center">
                            <h3 class="card-title h4 text-success">Recommendation</h3>
                            <p class="card-text text-dark">Recommended books based on past borrowing history or popular
                                books</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Borrowed Book Card -->
            <div class="col-md-4">
                <a href="../views/books/catalog.php" class="text-decoration-none">
                    <div class="card h-100 border-success hover-card">
                        <div class="card-body text-center">
                            <h3 class="card-title h4 text-success">Borrowed Books</h3>
                            <p class="card-text text-dark">List of currently borrowed books</p>
                        </div>
                    </div>
                </a>
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
            cursor: pointer;
        }

        .text-decoration-none:hover {
            text-decoration: none !important;
        }
    </style>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>