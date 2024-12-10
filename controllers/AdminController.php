<?php
require_once('/xampp/htdocs/Cohort-PHP-Assignments/LMS/config/database.php');

class AdminController
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    // Get total books count
    public function getTotalBooks()
    {
        $query = "SELECT COUNT(*) as total FROM books";
        $result = mysqli_query($this->conn, $query);
        return mysqli_fetch_assoc($result)['total'];
    }

    // Get currently borrowed books count
    public function getBorrowedBooks()
    {
        $query = "SELECT COUNT(*) as total FROM borrowings WHERE status = 'borrowed'";
        $result = mysqli_query($this->conn, $query);
        return mysqli_fetch_assoc($result)['total'];
    }

    // Get overdue books count
    public function getOverdueBooks()
    {
        $query = "SELECT COUNT(*) as total 
                FROM borrowings 
                WHERE status = 'borrowed' 
                AND return_date < CURDATE()";
        $result = mysqli_query($this->conn, $query);
        return mysqli_fetch_assoc($result)['total'];
    }

    // Get all books for management table
    public function getAllBooks()
    {
        $query = "SELECT b.*, 
                        CASE 
                            WHEN b.quantity > 0 THEN 'available'
                            ELSE 'borrowed'
                        END as status
                FROM books b 
                ORDER BY b.title";
        return mysqli_query($this->conn, $query);
    }

    // Add new book
    public function addBook($title, $author, $isbn, $quantity)
    {
        $title = mysqli_real_escape_string($this->conn, $title);
        $author = mysqli_real_escape_string($this->conn, $author);
        $isbn = mysqli_real_escape_string($this->conn, $isbn);

        $query = "INSERT INTO books (title, author, isbn, quantity) 
                VALUES ('$title', '$author', '$isbn', $quantity, $quantity)";
        return mysqli_query($this->conn, $query);
    }

    // Delete book
    public function deleteBook($id)
    {
        $id = mysqli_real_escape_string($this->conn, $id);
        $query = "DELETE FROM books WHERE id = $id";
        return mysqli_query($this->conn, $query);
    }

    // Update book
    public function updateBook($id, $title, $author, $isbn, $quantity)
    {
        $id = mysqli_real_escape_string($this->conn, $id);
        $title = mysqli_real_escape_string($this->conn, $title);
        $author = mysqli_real_escape_string($this->conn, $author);
        $isbn = mysqli_real_escape_string($this->conn, $isbn);

        $query = "UPDATE books 
                SET title = '$title', 
                    author = '$author', 
                    isbn = '$isbn', 
                    quantity = $quantity 
                WHERE id = $id";
        return mysqli_query($this->conn, $query);
    }
}
?>