<?php
require '../../config/database.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if username or email already exists
    $check_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        header('Location: ../../views/users/register.php?error=exists');
        exit();
    } else {
        $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        
        if (mysqli_query($conn, $query)) {
            header('Location: ../../views/users/login.php?registered=success');
            exit();
        } else {
            header('Location: ../../views/users/register.php?error=failed');
            exit();
        }
    }
}
?> 

<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">
        <?php 
            if ($_GET['error'] == 'exists') {
                echo "Username or email already exists!";
            } elseif ($_GET['error'] == 'failed') {
                echo "Registration failed. Please try again.";
            }
        ?>
    </div>
<?php endif; ?> 