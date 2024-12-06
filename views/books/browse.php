<?php
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
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container py-5">
    <!-- Search and Filter Section -->
    <div class="row mb-4">
        <div class="col-md-6">
            <form method="GET" action="">
                <div class="input-group">
                    <input type="text"
                        name="search"
                        class="form-control border-success"
                        placeholder="Search by title, author, category, or ISBN..."
                        value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                    <button class="btn btn-success" type="submit">
                        <i class="bi bi-search"></i> Search
                    </button>
                </div>
            </form>
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

                            <button class="btn btn-success btn-sm w-100 mt-2" data-bs-toggle="modal" data-bs-target="#borrowModal<?php echo $book['id']; ?>">
                                Borrow Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Borrow Modal -->
            <div class="modal fade" id="borrowModal<?php echo $book['id']; ?>" tabindex="-1" aria-labelledby="borrowModalLabel<?php echo $book['id']; ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title" id="borrowModalLabel<?php echo $book['id']; ?>">Borrow Book</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <h4><?php echo htmlspecialchars($book['title']); ?></h4>
                                <p class="text-muted">By <?php echo htmlspecialchars($book['author']); ?></p>
                            </div>
                            <div class="mb-3">
                                <strong>ISBN:</strong> 
                                <?php echo htmlspecialchars($book['isbn']); ?>
                            </div>
                            <div class="mb-3">
                                <strong>Availability:</strong>
                                <p><?php echo htmlspecialchars($book['available_quantity']); ?> of <?php echo htmlspecialchars($book['quantity']); ?> copies available</p>
                            </div>
                            <div class="mb-3">
                                <strong>Return Date:</strong>
                                <p class="text-danger"><?php echo date('F j, Y', strtotime('+2 weeks')); ?></p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <form action="index.php?controller=book&action=borrow&id=<?php echo $book['id']; ?>" method="POST">
                                <button type="submit" class="btn btn-success">Confirm Borrow</button>
                            </form>
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