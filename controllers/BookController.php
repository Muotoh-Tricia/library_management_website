<?php
session_start();
require_once('/xampp/htdocs/Cohort-PHP-Assignments/LMS/templates/header.php');
require_once('/xampp/htdocs/Cohort-PHP-Assignments/LMS/config/database.php');

class BookController
{
    private $conn;
    private $max_books_allowed = 3;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function borrow()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_id'])) {
            $book_id = mysqli_real_escape_string($this->conn, $_POST['book_id']);
            $user_id = $_SESSION['user_id'];

            // Check if user has already borrowed this book
            $check_query = "SELECT * FROM borrowings 
                           WHERE user_id = $user_id 
                           AND book_id = $book_id 
                           AND status = 'borrowed'";
            $check_result = mysqli_query($this->conn, $check_query);

            if (mysqli_num_rows($check_result) > 0) {
                $_SESSION['error'] = "You have already borrowed this book and haven't returned it yet.";
                header('Location: /Cohort-PHP-Assignments/LMS/views/books/browse.php');
                exit();
            }

            // Get the book details from the form
            $book_title = $_POST['book_title'];
            $book_author = $_POST['book_author'];

            mysqli_begin_transaction($this->conn);

            try {
                // Update book quantity
                $update_book = "UPDATE books 
                               SET quantity = quantity - 1 
                               WHERE id = $book_id 
                               AND quantity > 0";
                $result1 = mysqli_query($this->conn, $update_book);

                // Create borrowing record
                $return_date = date('Y-m-d', strtotime('+2 weeks'));
                $insert_borrow = "INSERT INTO borrowings (user_id, book_id, borrow_date, return_date, status) 
                                 VALUES ($user_id, $book_id, NOW(), '$return_date', 'borrowed')";
                $result2 = mysqli_query($this->conn, $insert_borrow);

                if ($result1 && $result2) {
                    mysqli_commit($this->conn);
                    $_SESSION['borrow_success'] = true;
                    $_SESSION['borrowed_book_title'] = $book_title;
                    $_SESSION['borrowed_book_author'] = $book_author;
                } else {
                    throw new Exception("Failed to borrow book");
                }
            } catch (Exception $e) {
                mysqli_rollback($this->conn);
                $_SESSION['error'] = "Failed to borrow book: " . $e->getMessage();
            }

            header('Location: /Cohort-PHP-Assignments/LMS/views/books/browse.php');
            exit();
        }
    }

    public function getUserBorrowedBooks($user_id)
    {
        $query = "SELECT b.*, br.borrow_date, br.return_date 
                 FROM borrowings br 
                 JOIN books b ON br.book_id = b.id 
                 WHERE br.user_id = $user_id 
                 AND br.status = 'borrowed'";
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            error_log("Query failed: " . mysqli_error($this->conn));
            return false;
        }

        return $result;
    }

    public function returnBook()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_id'])) {
            $book_id = mysqli_real_escape_string($this->conn, $_POST['book_id']);
            $user_id = $_SESSION['user_id'];

            mysqli_begin_transaction($this->conn);

            try {
                // Update borrowing status to 'returned'
                $update_borrow = "UPDATE borrowings 
                                 SET status = 'returned', 
                                     actual_return_date = NOW() 
                                 WHERE user_id = $user_id 
                                 AND book_id = $book_id 
                                 AND status = 'borrowed'";
                $result1 = mysqli_query($this->conn, $update_borrow);

                // Increase available quantity of the book
                $update_book = "UPDATE books 
                               SET quantity = quantity + 1 
                               WHERE id = $book_id";
                $result2 = mysqli_query($this->conn, $update_book);

                if ($result1 && $result2) {
                    mysqli_commit($this->conn);
                    $_SESSION['return_success'] = true;
                    $_SESSION['message'] = "Book has been returned successfully!";
                } else {
                    throw new Exception("Failed to return book");
                }
            } catch (Exception $e) {
                mysqli_rollback($this->conn);
                $_SESSION['error'] = "Failed to return book: " . $e->getMessage();
            }

            header('Location: /Cohort-PHP-Assignments/LMS/views/books/borrowed_books.php');
            exit();
        }
    }

    public function getOverdueBooks($user_id)
    {
        $query = "SELECT b.*, br.borrow_date, br.return_date 
                 FROM borrowings br 
                 JOIN books b ON br.book_id = b.id 
                 WHERE br.user_id = $user_id 
                 AND br.status = 'borrowed'
                 AND br.return_date < NOW()";
        return mysqli_query($this->conn, $query);
    }

    public function getReturnHistory($user_id)
    {
        $query = "SELECT b.*, 
                        br.borrow_date, 
                        br.return_date,
                        br.actual_return_date,
                        CASE 
                            WHEN br.actual_return_date > br.return_date THEN 'Overdue'
                            ELSE 'On Time'
                        END as return_status
                 FROM borrowings br 
                 JOIN books b ON br.book_id = b.id 
                 WHERE br.user_id = $user_id 
                 AND br.status = 'returned'
                 ORDER BY br.actual_return_date DESC";
        return mysqli_query($this->conn, $query);
    }

    public function getRecommendedBooks($user_id, $limit = 4)
    {
        // Get books similar to user's previously borrowed books (same author or category)
        $similar_books_query = "
            SELECT DISTINCT b.* 
            FROM books b
            JOIN borrowings br1 ON b.id != br1.book_id
            WHERE b.author IN (
                SELECT DISTINCT b2.author 
                FROM borrowings br2
                JOIN books b2 ON br2.book_id = b2.id
                WHERE br2.user_id = $user_id
            )
            AND b.id NOT IN (
                SELECT book_id 
                FROM borrowings 
                WHERE user_id = $user_id
            )
            LIMIT " . ($limit / 2);

        // Get popular books (most borrowed books that user hasn't borrowed)
        $popular_books_query = "
            SELECT b.*, COUNT(br.id) as borrow_count
            FROM books b
            JOIN borrowings br ON b.id = br.book_id
            WHERE b.id NOT IN (
                SELECT book_id 
                FROM borrowings 
                WHERE user_id = $user_id
            )
            GROUP BY b.id
            ORDER BY borrow_count DESC
            LIMIT " . ($limit / 2);

        $similar_books = mysqli_query($this->conn, $similar_books_query);
        $popular_books = mysqli_query($this->conn, $popular_books_query);

        $recommendations = [
            'similar' => $similar_books ? mysqli_fetch_all($similar_books, MYSQLI_ASSOC) : [],
            'popular' => $popular_books ? mysqli_fetch_all($popular_books, MYSQLI_ASSOC) : []
        ];

        return $recommendations;
    }
}

// Handle the request
if (isset($_POST['action'])) {
    $controller = new BookController();

    switch ($_POST['action']) {
        case 'borrow':
            $controller->borrow();
            break;
        case 'return':
            $controller->returnBook();
            break;
    }
}
