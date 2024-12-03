<?php require_once '../views/layouts/main.php'; ?>

<div class="container mt-5">
    <h1 class="mb-4">Register</h1>
    <form method="POST" action="../../controllers/register.php">
        <div class="form-group mb-3">
            <label>Username:</label>
            <input type="text" class="form-control" name="username" required>
        </div>
        <div class="form-group mb-3">
            <label>Email:</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="form-group mb-3">
            <label>Password:</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <button type="submit" class="btn btn-success">Register</button>
    </form>
    <p class="mt-3">Already have an account? <a href="index.php?controller=auth&action=login">Login here</a></p>
</div>