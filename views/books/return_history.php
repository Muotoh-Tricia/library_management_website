<?php
require_once '/xampp/htdocs/Cohort-PHP-Assignments/LMS/templates/header.php';
require_once '/xampp/htdocs/Cohort-PHP-Assignments/LMS/config/database.php';
require_once '/xampp/htdocs/Cohort-PHP-Assignments/LMS/controllers/BookController.php';

$bookController = new BookController();
$user_id = $_SESSION['user_id'];
$return_history = $bookController->getReturnHistory($user_id);
$overdue_books = $bookController->getOverdueBooks($user_id);
?>

<div class="container py-5">
    <!-- Overdue Books Alert -->
    <?php if (mysqli_num_rows($overdue_books) > 0): ?>
        <div class="alert alert-danger mb-4">
            <h5 class="alert-heading">⚠️ Overdue Books</h5>
            <ul class="mb-0">
                <?php while ($book = mysqli_fetch_assoc($overdue_books)): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($book['title']); ?></strong> - 
                        Due: <?php echo date('F j, Y', strtotime($book['return_date'])); ?>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Return History -->
    <h2 class="text-success mb-4">Return History</h2>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-success">
                <tr>
                    <th>Book Title</th>
                    <th>Author</th>
                    <th>Borrowed Date</th>
                    <th>Due Date</th>
                    <th>Returned Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($return_history) > 0): ?>
                    <?php while ($book = mysqli_fetch_assoc($return_history)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($book['title']); ?></td>
                            <td><?php echo htmlspecialchars($book['author']); ?></td>
                            <td><?php echo date('M j, Y', strtotime($book['borrow_date'])); ?></td>
                            <td><?php echo date('M j, Y', strtotime($book['return_date'])); ?></td>
                            <td><?php echo date('M j, Y', strtotime($book['actual_return_date'])); ?></td>
                            <td>
                                <?php if ($book['return_status'] === 'Overdue'): ?>
                                    <span class="badge bg-danger">Overdue</span>
                                <?php else: ?>
                                    <span class="badge bg-success">On Time</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No return history available</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>