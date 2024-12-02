<?php
class Book {
    private $conn;
    private $table = "books";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM {$this->table}";
        return mysqli_query($this->conn, $query);
    }

    public function getById($id) {
        $id = mysqli_real_escape_string($this->conn, $id);
        $query = "SELECT * FROM {$this->table} WHERE id = '$id'";
        return mysqli_query($this->conn, $query);
    }

    public function create($data) {
        $title = mysqli_real_escape_string($this->conn, $data['title']);
        $author = mysqli_real_escape_string($this->conn, $data['author']);
        $isbn = mysqli_real_escape_string($this->conn, $data['isbn']);
        $quantity = (int)$data['quantity'];

        $query = "INSERT INTO {$this->table} (title, author, isbn, quantity, available_quantity) 
                 VALUES ('$title', '$author', '$isbn', $quantity, $quantity)";
        
        return mysqli_query($this->conn, $query);
    }

    public function update($id, $data) {
        $title = mysqli_real_escape_string($this->conn, $data['title']);
        $author = mysqli_real_escape_string($this->conn, $data['author']);
        $isbn = mysqli_real_escape_string($this->conn, $data['isbn']);
        $quantity = (int)$data['quantity'];
        $id = mysqli_real_escape_string($this->conn, $id);

        $query = "UPDATE {$this->table} 
                 SET title='$title', author='$author', isbn='$isbn', quantity=$quantity 
                 WHERE id='$id'";
        
        return mysqli_query($this->conn, $query);
    }

    public function delete($id) {
        $id = mysqli_real_escape_string($this->conn, $id);
        $query = "DELETE FROM {$this->table} WHERE id='$id'";
        return mysqli_query($this->conn, $query);
    }
}
