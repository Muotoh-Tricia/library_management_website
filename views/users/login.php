<?php require_once '../views/layouts/main.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-success">
                <div class="card-header bg-success text-white">
                    <h3 class="mb-0">Login</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="index.php?controller=auth&action=login">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username:</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Login</button>
                    </form>
                    <div class="mt-3 text-center">
                        <p>Don't have an account? 
                            <a href="#" class="text-success" data-bs-toggle="modal" data-bs-target="#registerModal">Register here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Register</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="index.php?controller=user&action=register">
                        <div class="mb-3">
                            <label for="reg-username" class="form-label">Username:</label>
                            <input type="text" class="form-control" id="reg-username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="reg-email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="reg-email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="reg-password" class="form-label">Password:</label>
                            <input type="password" class="form-control" id="reg-password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
