<?php
session_start();
require_once('/xampp/htdocs/Cohort-PHP-Assignments/LMS/templates/header.php');
require_once('/xampp/htdocs/Cohort-PHP-Assignments/LMS/config/database.php');

if (!$conn) {
    die("Database connection not established.");
}

$search = mysqli_real_escape_string($conn, $_GET['search'] ?? '');

$query = "SELECT * FROM books WHERE title LIKE '%$search%' OR author LIKE '%$search%' OR isbn LIKE '%$search%' ORDER BY title ASC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}


if (isset($_SESSION)) {
    echo "<!-- Session variables: ";
    var_dump($_SESSION);
    echo " -->";
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container py-5">
    <!-- Search Section -->
    <div class="row mb-4">
        <div class="col-md-6 mx-auto">
            <form method="GET" action="" class="shadow-sm rounded-3 overflow-hidden">
                <div class="input-group">
                    <input type="text"
                        name="search"
                        class="form-control border-0 py-3"
                        placeholder="Search by title, author, or ISBN..."
                        value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                    <button class="btn btn-success px-4" type="submit">
                        <i class="bi bi-search"></i> Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Error Alert -->
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?php echo $_SESSION['error']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Books Grid -->
    <div class="row g-4">
        <?php while ($book = mysqli_fetch_assoc($result)): ?>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm rounded-3 border-0">
                    <img src="<?php echo htmlspecialchars($book['image_url']); ?>"
                        class="card-img-top p-3"
                        alt="<?php echo htmlspecialchars($book['title']); ?>">

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold text-truncate">
                            <?php echo htmlspecialchars($book['title']); ?>
                        </h5>

                        <p class="card-text text-muted mb-2">
                            <i class="bi bi-person-circle me-2"></i>
                            <?php echo htmlspecialchars($book['author']); ?>
                        </p>

                        <p class="card-text small mb-3">
                            <i class="bi bi-upc me-2"></i>
                            <?php echo htmlspecialchars($book['isbn']); ?>
                        </p>

                        <div class="mt-auto">
                            <?php if ($book['quantity'] > 0): ?>
                                <div class="d-flex align-items-center mb-3">
                                    <span class="badge bg-success-subtle text-success rounded-pill me-2">
                                        <i class="bi bi-check-circle me-1"></i> Available
                                    </span>
                                    <small class="text-success">
                                        <?php echo htmlspecialchars($book['quantity']); ?> left
                                    </small>
                                </div>
                                <button class="btn btn-success w-100"
                                    data-bs-toggle="modal"
                                    data-bs-target="#borrowModal<?php echo $book['id']; ?>">
                                    <i class="bi bi-book me-2"></i>
                                    Borrow Now
                                </button>
                            <?php else: ?>
                                <div class="d-flex align-items-center mb-3">
                                    <span class="badge bg-danger-subtle text-danger rounded-pill me-2">
                                        <i class="bi bi-x-circle me-1"></i> Out of Stock
                                    </span>
                                </div>
                                <button class="btn btn-secondary w-100" disabled>
                                    <i class="bi bi-clock me-2"></i>
                                    Currently Unavailable
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Borrow Modal -->
            <div class="modal fade" id="borrowModal<?php echo $book['id']; ?>" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header bg-success text-white border-0">
                            <h5 class="modal-title">
                                <i class="bi bi-book me-2"></i>
                                Borrow Book
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="text-center mb-4">
                                <img src="<?php echo htmlspecialchars($book['image_url']); ?>"
                                    class="rounded-3 shadow-sm mb-3"
                                    style="height: 150px;">
                                <h5><?php echo htmlspecialchars($book['title']); ?></h5>
                                <p class="text-muted">By <?php echo htmlspecialchars($book['author']); ?></p>
                            </div>
                            <div class="alert alert-warning border-0">
                                <i class="bi bi-calendar-event me-2"></i>
                                Please return by: <?php echo date('F j, Y', strtotime('+2 weeks')); ?>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <form action="/Cohort-PHP-Assignments/LMS/controllers/BookController.php" method="POST">
                                <input type="hidden" name="action" value="borrow">
                                <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                                <input type="hidden" name="book_title" value="<?php echo htmlspecialchars($book['title']); ?>">
                                <input type="hidden" name="book_author" value="<?php echo htmlspecialchars($book['author']); ?>">
                                <button type="submit" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#successModal">
                                    Confirm Borrow
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>

        <?php if (mysqli_num_rows($result) == 0): ?>
            <div class="col-12">
                <div class="alert alert-info text-center shadow-sm">
                    <i class="bi bi-info-circle me-2"></i>
                    No books found matching your search.
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-success text-white border-0">
                    <h5 class="modal-title">
                        <i class="bi bi-check-circle me-2"></i>
                        Congratulations!
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <div class="display-1 text-success mb-4">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <h4 class="mb-4">
                        You've Successfully Borrowed This Book!
                    </h4>
                    <h5 class="text-success mb-3">
                        <?php echo htmlspecialchars($_SESSION['borrowed_book_title']); ?>
                    </h5>
                    <p class="text-muted mb-3">
                        By <?php echo htmlspecialchars($_SESSION['borrowed_book_author']); ?>
                    </p>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">
                        <i class="bi bi-check-lg me-2"></i>
                        Got it!
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        transition: transform 0.2s ease-in-out;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card-img-top {
        height: 250px;
        object-fit: cover;
    }

    .btn-success {
        background-color: #198754;
        border: none;
    }

    .btn-success:hover {
        background-color: #146c43;
    }
</style>


<?php if (isset($_SESSION['borrow_success'])): ?>
    <script>
        window.onload = function() {
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();

            // Clear the session variables after showing the modal
            <?php
            unset($_SESSION['borrow_success']);
            unset($_SESSION['borrowed_book_title']);
            unset($_SESSION['borrowed_book_author']);
            ?>
        };
    </script>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>