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
}
