<?php
class Borrowing
{
    private $conn;
    private $table = "borrowings";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        $query = "SELECT b.*, u.username, bk.title 
                 FROM {$this->table} b
                 JOIN users u ON b.user_id = u.id
                 JOIN books bk ON b.book_id = bk.id";
        return mysqli_query($this->conn, $query);
    }

    public function create($data)
    {
        $user_id = (int) $data['user_id'];
        $book_id = (int) $data['book_id'];
        $return_date = mysqli_real_escape_string($this->conn, $data['return_date']);

        $query = "INSERT INTO {$this->table} (user_id, book_id, return_date) 
                 VALUES ($user_id, $book_id, '$return_date')";

        return mysqli_query($this->conn, $query);
    }

    public function returnBook($id)
    {
        $id = (int) $id;
        $query = "UPDATE {$this->table} 
                 SET status='returned' 
                 WHERE id=$id";

        return mysqli_query($this->conn, $query);
    }
}
