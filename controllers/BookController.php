<?php
require_once '../models/Book.php';

class BookController {
    private $book;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->book = new Book($this->db);
    }

    public function index() {
        $books = $this->book->getAll();
        require_once '../views/books/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->book->create($_POST)) {
                header('Location: index.php?controller=book&action=index');
                exit();
            }
        }
        require_once '../views/books/create.php';
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->book->update($id, $_POST)) {
                header('Location: index.php?controller=book&action=index');
                exit();
            }
        }
        $book = $this->book->getById($id);
        require_once '../views/books/edit.php';
    }
}
