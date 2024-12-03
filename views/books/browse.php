<?php require_once("/xampp/htdocs/Cohort-PHP-Assignments/LMS/templates/header.php");

require_once '../../config/database.php';

if (!$conn) {
    die("Database connection not established.");
}

$query = "SELECT * FROM books ORDER BY title ASC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container py-5">
    <!-- Search and Filter Section -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="input-group">
                <input type="text" class="form-control border-success" placeholder="Search books...">
                <button class="btn btn-success" type="button">Search</button>
            </div>
        </div>
    </div>

    <!-- Books Display Section -->
    <div class="row g-4">
        <?php while ($book = mysqli_fetch_assoc($result)): ?>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 border-success shadow-sm hover-shadow">
                    <!-- Display Book Cover Image -->
                    <img src="<?php echo htmlspecialchars($book['image_url']); ?>" class="card-img-top p-3" alt="Book Cover">

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-truncate text-success" title="<?php echo htmlspecialchars($book['title']); ?>">
                            <?php echo htmlspecialchars($book['title']); ?>
                        </h5>

                        <p class="card-text text-muted mb-1">
                            By <?php echo htmlspecialchars($book['author']); ?>
                        </p>

                        <p class="card-text small mb-1">
                            ISBN: <?php echo htmlspecialchars($book['isbn']); ?>
                        </p>

                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-success">
                                    Available
                                </span>
                                <small class="text-success">
                                    <?php echo htmlspecialchars($book['available_quantity']); ?> of
                                    <?php echo htmlspecialchars($book['quantity']); ?> left
                                </small>
                            </div>

                            <button class="btn btn-success btn-sm w-100 mt-2">
                                Borrow Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>

        <?php if (mysqli_num_rows($result) == 0): ?>
            <div class="col-12">
                <div class="alert alert-success text-center">
                    <i class="bi bi-info-circle me-2"></i>
                    No books available at the moment.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .hover-shadow:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
        transition: all 0.3s ease;
    }

    .card {
        transition: all 0.3s ease;
    }

    .card-img-top {
        height: 200px;
        object-fit: cover;
    }

    /* Custom success color overrides if needed */
    .btn-success,
    .bg-success {
        background-color: #198754 !important;
    }

    .border-success {
        border-color: #198754 !important;
    }

    .text-success {
        color: #198754 !important;
    }
</style>

<?php require_once("/xampp/htdocs/Cohort-PHP-Assignments/LMS/templates/footer.php");
