<?php
// Check if the path to database.php is correct
require_once '/xampp/htdocs/Cohort-PHP-Assignments/LMS/config/database.php';

// Add error checking for database connection
// if (!isset($connect)) {
//     die("Database connection not established. Check the path to database.php");
// }

// Test query to see if books exist
$query = "SELECT * FROM books ORDER BY title ASC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<div class="container py-5">
    <h2 class="mb-4">Available Books</h2>

    <div class="row">
        <?php while ($book = mysqli_fetch_assoc($result)): ?>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($book['title']); ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted">By <?php echo htmlspecialchars($book['author']); ?></h6>
                        <p class="card-text">
                            <small class="text-muted">ISBN: <?php echo htmlspecialchars($book['isbn']); ?></small>
                        </p>
                        <p class="card-text">
                            Available: <?php echo htmlspecialchars($book['available_quantity']); ?> of <?php echo htmlspecialchars($book['quantity']); ?>
                        </p>
                        <span class="badge <?php echo $book['available_quantity'] > 0 ? 'bg-success' : 'bg-danger'; ?>">
                            <?php echo $book['available_quantity'] > 0 ? 'Available' : 'Not Available'; ?>
                        </span>
                        <?php if ($book['available_quantity'] > 0): ?>
                            <button class="btn btn-success btn-sm mt-2">Borrow</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>

        <?php if (mysqli_num_rows($result) == 0): ?>
            <div class="col-12">
                <div class="alert alert-info text-center">
                    No books available at the moment.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>