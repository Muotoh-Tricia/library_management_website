<?php
class User {
    private $conn;
    private $table = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($data) {
        $username = mysqli_real_escape_string($this->conn, $data['username']);
        $email = mysqli_real_escape_string($this->conn, $data['email']);
        $password = password_hash($data['password'], PASSWORD_DEFAULT);

        $query = "INSERT INTO {$this->table} (username, email, password) 
                 VALUES ('$username', '$email', '$password')";
        
        return mysqli_query($this->conn, $query);
    }

    public function login($username, $password) {
        $username = mysqli_real_escape_string($this->conn, $username);
        
        $query = "SELECT * FROM {$this->table} WHERE username='$username'";
        $result = mysqli_query($this->conn, $query);
        
        if ($user = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }
        return false;
    }

    public function verifyPassword($user_id, $current_password) {
        $user_id = mysqli_real_escape_string($this->conn, $user_id);
        $query = "SELECT password FROM {$this->table} WHERE id = '$user_id'";
        $result = mysqli_query($this->conn, $query);

        if ($row = mysqli_fetch_assoc($result)) {
            return password_verify($current_password, $row['password']);
        }
        return false;
    }

    public function updateProfile($user_id, $data) {
        $user_id = mysqli_real_escape_string($this->conn, $user_id);
        $username = mysqli_real_escape_string($this->conn, $data['username']);
        $email = mysqli_real_escape_string($this->conn, $data['email']);
        
        $query = "UPDATE {$this->table} SET username='$username', email='$email'";
        
        if (!empty($data['new_password'])) {
            $password = password_hash($data['new_password'], PASSWORD_DEFAULT);
            $query .= ", password='$password'";
        }
        
        $query .= " WHERE id='$user_id'";
        
        return mysqli_query($this->conn, $query);
    }
}
