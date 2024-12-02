<?php require_once '../views/layouts/main.php'; ?>

<div class="container">
    <h1>Register</h1>
    <form method="POST" action="index.php?controller=user&action=register">
        <div class="form-group">
            <label>Username:</label>
            <input type="text" name="username" required>
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit" class="btn">Register</button>
    </form>
    <p>Already have an account? <a href="index.php?controller=auth&action=login">Login here</a></p>
</div>
