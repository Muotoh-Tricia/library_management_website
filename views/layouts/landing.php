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
                    <img src="../assets/book.jpg" class="img-fluid rounded" alt="Library">
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container py-5">
        <h2 class="text-center text-success mb-5">Our Features</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-success">
                    <div class="card-body text-center">
                        <h3 class="card-title h4 text-success">Browse Books</h3>
                        <p class="card-text">Access our extensive collection</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-success">
                    <div class="card-body text-center">
                        <h3 class="card-title h4 text-success">Easy Borrowing</h3>
                        <p class="card-text">Simple checkout process</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-success">
                    <div class="card-body text-center">
                        <h3 class="card-title h4 text-success">Digital Catalog</h3>
                        <p class="card-text">Search and find books easily</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../templates/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>