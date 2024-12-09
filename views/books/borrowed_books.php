<?php
require_once '/xampp/htdocs/Cohort-PHP-Assignments/LMS/templates/header.php';
require_once '/xampp/htdocs/Cohort-PHP-Assignments/LMS/config/database.php';
require_once '/xampp/htdocs/Cohort-PHP-Assignments/LMS/controllers/BookController.php';

$bookController = new BookController();
$user_id = $_SESSION['user_id'];
$borrowed_books = $bookController->getUserBorrowedBooks($user_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrowed Books</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <!-- Success Alert -->
        <?php if (isset($_SESSION['return_success'])): ?>
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <?php echo $_SESSION['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php 
                unset($_SESSION['return_success']);
                unset($_SESSION['message']);
            ?>
        <?php endif; ?>

        
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-success mb-0">
                <i class="bi bi-book me-2"></i>
                My Borrowed Books
            </h2>
            <a href="/Cohort-PHP-Assignments/LMS/views/books/browse.php" class="btn btn-outline-success">
                <i class="bi bi-plus-lg me-2"></i>
                Borrow More Books
            </a>
        </div>

        <!-- Books Grid -->
        <div class="row g-4">
            <?php if (mysqli_num_rows($borrowed_books) > 0): ?>
                <?php while ($book = mysqli_fetch_assoc($borrowed_books)): ?>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                            <div class="position-relative">
                                <img src="<?php echo htmlspecialchars($book['image_url']); ?>"
                                    class="card-img-top p-3"
                                    alt="Book Cover"
                                    style="height: 250px; object-fit: cover;">
                            </div>

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold text-success mb-2">
                                    <?php echo htmlspecialchars($book['title']); ?>
                                </h5>

                                <p class="card-text text-muted mb-3">
                                    <i class="bi bi-person-circle me-2"></i>
                                    <?php echo htmlspecialchars($book['author']); ?>
                                </p>

                                <div class="mt-auto">
                                    <div class="card bg-light border-0 rounded-3 mb-3">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between mb-2">
                                                <small class="text-muted">
                                                    <i class="bi bi-calendar-check me-2"></i>
                                                    Borrowed on
                                                </small>
                                                <small class="text-success fw-bold">
                                                    <?php echo date('M j, Y', strtotime($book['borrow_date'])); ?>
                                                </small>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <small class="text-muted">
                                                    <i class="bi bi-calendar-x me-2"></i>
                                                    Return by
                                                </small>
                                                <small class="text-danger fw-bold">
                                                    <?php echo date('M j, Y', strtotime($book['return_date'])); ?>
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    <button class="btn btn-success w-100"
                                        data-bs-toggle="modal"
                                        data-bs-target="#returnModal<?php echo $book['id']; ?>">
                                        <i class="bi bi-arrow-return-left me-2"></i>
                                        Return Book
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Return Modal -->
                    <div class="modal fade" id="returnModal<?php echo $book['id']; ?>" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <div class="modal-header bg-success text-white border-0">
                                    <h5 class="modal-title">
                                        <i class="bi bi-arrow-return-left me-2"></i>
                                        Return Book
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <div class="text-center mb-4">
                                        <img src="<?php echo htmlspecialchars($book['image_url']); ?>"
                                            alt="Book Cover"
                                            class="rounded-3 shadow-sm mb-3"
                                            style="height: 150px;">
                                        <h5 class="mb-1"><?php echo htmlspecialchars($book['title']); ?></h5>
                                        <p class="text-muted">By <?php echo htmlspecialchars($book['author']); ?></p>
                                    </div>
                                    <div class="alert alert-warning border-0 rounded-3">
                                        <i class="bi bi-exclamation-circle me-2"></i>
                                        Are you sure you want to return this book?
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                    <form action="/Cohort-PHP-Assignments/LMS/controllers/BookController.php" method="POST">
                                        <input type="hidden" name="action" value="return">
                                        <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                                        <button type="submit" class="btn btn-success">
                                            <i class="bi bi-check-lg me-2"></i>
                                            Confirm Return
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info border-0 shadow-sm rounded-3 text-center p-4">
                        <i class="bi bi-info-circle display-5 text-info mb-3"></i>
                        <h5>No Books Borrowed Yet</h5>
                        <p class="mb-3">You haven't borrowed any books from our library.</p>
                        <a href="/Cohort-PHP-Assignments/LMS/views/books/browse.php"
                            class="btn btn-info text-white">
                            <i class="bi bi-book me-2"></i>
                            Browse Books
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Success Return Modal -->
    <div class="modal fade" id="returnSuccessModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-success text-white border-0">
                    <h5 class="modal-title">
                        <i class="bi bi-check-circle me-2"></i>
                        Success!
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <div class="display-1 text-success mb-4">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <h4 class="mb-4">Book Successfully Returned!</h4>
                    <p class="text-muted mb-4">
                        Thank you for returning the book on time.
                    </p>
                    <button type="button" class="btn btn-success px-4" data-bs-dismiss="modal">
                        <i class="bi bi-check-lg me-2"></i>
                        Got it!
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add this right after your success modal -->
    <?php if (isset($_SESSION['return_success'])): ?>
        <script>
            window.onload = function() {
                var returnSuccessModal = new bootstrap.Modal(document.getElementById('returnSuccessModal'));
                returnSuccessModal.show();
                <?php unset($_SESSION['return_success']); ?>
            };
        </script>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>