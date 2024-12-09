<?php
require_once('/xampp/htdocs/Cohort-PHP-Assignments/LMS/templates/header.php');
require_once('/xampp/htdocs/Cohort-PHP-Assignments/LMS/config/database.php');
require_once('/xampp/htdocs/Cohort-PHP-Assignments/LMS/controllers/BookController.php');

$controller = new BookController();

$recommendations = $controller->getRecommendedBooks($_SESSION['user_id']);
?>

<div class="container py-5">
    <div class="row mb-5">
        <div class="col-12">
            <h1 class="text-success mb-4">Recommended Books</h1>
        </div>
    </div>

    <?php if (!empty($recommendations['similar'])): ?>
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="h4 text-success mb-4">Based on Your Reading History</h2>
            </div>
        </div>
        <div class="row g-4 mb-5">
            <?php foreach ($recommendations['similar'] as $book): ?>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm rounded-3 border-0">
                        <img src="<?php echo htmlspecialchars($book['image_url']); ?>" class="card-img-top p-3"
                            alt="<?php echo htmlspecialchars($book['title']); ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-success">
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
                                <button class="btn btn-success w-100" data-bs-toggle="modal"
                                    data-bs-target="#borrowModal<?php echo $book['id']; ?>">
                                    <i class="bi bi-book me-2"></i>
                                    Borrow Now
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Popular Books -->
    <?php if (!empty($recommendations['popular'])): ?>
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="h4 text-success mb-4">Popular Books</h2>
            </div>
        </div>
        <div class="row g-4">
            <?php foreach ($recommendations['popular'] as $book): ?>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm rounded-3 border-0">
                        <img src="<?php echo htmlspecialchars($book['image_url']); ?>" class="card-img-top p-3"
                            alt="<?php echo htmlspecialchars($book['title']); ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-success">
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
                                <button class="btn btn-success w-100" data-bs-toggle="modal"
                                    data-bs-target="#borrowModal<?php echo $book['id']; ?>">
                                    <i class="bi bi-book me-2"></i>
                                    Borrow Now
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (empty($recommendations['similar']) && empty($recommendations['popular'])): ?>
        <div class="alert alert-info text-center">
            <i class="bi bi-info-circle me-2"></i>
            No recommendations available at the moment. Try borrowing some books first!
        </div>
    <?php endif; ?>
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
</style>