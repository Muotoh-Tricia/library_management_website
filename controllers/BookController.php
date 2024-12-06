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
            // Start session if not already started
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Get book details
            $query = "SELECT * FROM books WHERE id = $id";
            $result = mysqli_query($this->conn, $query);
            $book = mysqli_fetch_assoc($result);

            if ($book && $book['status'] === 'available') {
                // Update book status
                $update_query = "UPDATE books SET status = 'borrowed' WHERE id = $id";

                // Insert into borrowings table
                $user_id = $_SESSION['user_id']; // Ensure this session variable is set
                $borrow_date = date('Y-m-d');
                $return_date = date('Y-m-d', strtotime('+2 weeks'));

                $borrow_query = "INSERT INTO borrowings (user_id, book_id, borrow_date, return_date, status) 
                                VALUES ($user_id, $id, '$borrow_date', '$return_date', 'active')";

                if (mysqli_query($this->conn, $update_query) && mysqli_query($this->conn, $borrow_query)) {
                    $_SESSION['success'] = "Book borrowed successfully";
                } else {
                    $_SESSION['error'] = "Error borrowing book: " . mysqli_error($this->conn);
                }
            } else {
                $_SESSION['error'] = "Book is not available for borrowing";
            }
            header('Location: index.php?controller=book&action=index');
            exit();
        }
    }
}

