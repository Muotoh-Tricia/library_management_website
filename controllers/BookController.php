<?php
require_once '../config/database.php';
require_once '../models/Book.php';

class BookController
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function index()
    {
        $query = "SELECT * FROM books ORDER BY title ASC";
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            die("Query failed: " . mysqli_error($this->conn));
        }

        require_once '../views/books/browse.php';
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = mysqli_real_escape_string($this->conn, $_POST['title']);
            $author = mysqli_real_escape_string($this->conn, $_POST['author']);
            $isbn = mysqli_real_escape_string($this->conn, $_POST['isbn']);
            $category = mysqli_real_escape_string($this->conn, $_POST['category']);
            $description = mysqli_real_escape_string($this->conn, $_POST['description']);

            $query = "INSERT INTO books (title, author, isbn, category, description, status) 
                     VALUES ('$title', '$author', '$isbn', '$category', '$description', 'available')";

            if (mysqli_query($this->conn, $query)) {
                header('Location: index.php?controller=book&action=index');
                exit();
            } else {
                die("Error: " . mysqli_error($this->conn));
            }
        }
        require_once '../views/books/create.php';
    }

    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = mysqli_real_escape_string($this->conn, $_POST['title']);
            $author = mysqli_real_escape_string($this->conn, $_POST['author']);
            $isbn = mysqli_real_escape_string($this->conn, $_POST['isbn']);
            $category = mysqli_real_escape_string($this->conn, $_POST['category']);
            $description = mysqli_real_escape_string($this->conn, $_POST['description']);

            $query = "UPDATE books SET 
                     title = '$title',
                     author = '$author',
                     isbn = '$isbn',
                     category = '$category',
                     description = '$description'
                     WHERE id = $id";

            if (mysqli_query($this->conn, $query)) {
                header('Location: index.php?controller=book&action=index');
                exit();
            } else {
                die("Error: " . mysqli_error($this->conn));
            }
        }

        $query = "SELECT * FROM books WHERE id = $id";
        $result = mysqli_query($this->conn, $query);
        $book = mysqli_fetch_assoc($result);

        require_once '../views/books/edit.php';
    }

    public function borrow($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Get book details
            $query = "SELECT * FROM books WHERE id = $id";
            $result = mysqli_query($this->conn, $query);
            $book = mysqli_fetch_assoc($result);

            if ($book && $book['available_quantity'] > 0) {
                // Start transaction
                mysqli_begin_transaction($this->conn);

                try {
                    // Update book quantity
                    $update_query = "UPDATE books 
                               SET available_quantity = available_quantity - 1 
                               WHERE id = $id";
                    mysqli_query($this->conn, $update_query);

                    // Add borrowing record
                    $user_id = $_SESSION['user_id'];
                    $borrow_date = date('Y-m-d');
                    $return_date = date('Y-m-d', strtotime('+2 weeks'));

                    $borrow_query = "INSERT INTO borrowings (user_id, book_id, borrow_date, return_date, status) 
                                VALUES ($user_id, $id, '$borrow_date', '$return_date', 'borrowed')";
                    mysqli_query($this->conn, $borrow_query);

                    // Add transaction record
                    $transaction_query = "INSERT INTO transactions (user_id, book_id, transaction_type) 
                                    VALUES ($user_id, $id, 'borrow')";
                    mysqli_query($this->conn, $transaction_query);

                    // If all queries successful, commit transaction
                    mysqli_commit($this->conn);
                    $_SESSION['borrow_success'] = true;
                    $_SESSION['borrow_book_title'] = $book['title'];
                } catch (Exception $e) {
                    // If any query fails, rollback all changes
                    mysqli_rollback($this->conn);
                    $_SESSION['error'] = "Error processing transaction: " . $e->getMessage();
                }
            } else {
                $_SESSION['error'] = "Book is not available for borrowing";
            }
            header('Location: /Cohort-PHP-Assignments/LMS/views/books/browse.php');
            exit();
        }
    }
}

