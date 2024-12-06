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
                    <a href="../views/users/login.php" class="btn btn-success btn-lg px-4">Get Started</a>
                </div>
                <div class="col-lg-6">
                    <img src="../../assets/book.jpg" class="img-fluid rounded" alt="Library">
                </div>
            </div>
        </div>
    </div>

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

            <!-- Easy Borrowing Card -->
            <div class="col-md-4">
                <a href="../views/books/borrow.php" class="text-decoration-none">
                    <div class="card h-100 border-success hover-card">
                        <div class="card-body text-center">
                            <h3 class="card-title h4 text-success">Easy Borrowing</h3>
                            <p class="card-text text-dark">Simple checkout process</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Digital Catalog Card -->
            <div class="col-md-4">
                <a href="../views/books/catalog.php" class="text-decoration-none">
                    <div class="card h-100 border-success hover-card">
                        <div class="card-body text-center">
                            <h3 class="card-title h4 text-success">Digital Catalog</h3>
                            <p class="card-text text-dark">Search and find books easily</p>
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