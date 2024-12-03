<?php require '../../templates/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger">
                    <?php 
                        if ($_GET['error'] == 'invalid') {
                            echo "Invalid password!";
                        } elseif ($_GET['error'] == 'notfound') {
                            echo "Username not found!";
                        }
                    ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['registered']) && $_GET['registered'] == 'success'): ?>
                <div class="alert alert-success">
                    Registration successful! Please login.
                </div>
            <?php endif; ?>

            <div class="card border-success shadow-sm">
                <div class="card-header bg-success text-white py-3">
                    <h3 class="mb-0 text-center">Welcome Back</h3>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="../../controllers/login.php">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control form-control-lg" id="username" name="username" required>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control form-control-lg" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-success btn-lg w-100">Login</button>
                    </form>
                    <div class="mt-4 text-center">
                        <p class="mb-0">Don't have an account?
                            <a href="#" class="text-success fw-bold" data-bs-toggle="modal" data-bs-target="#registerModal">
                                Register here
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Create an Account</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form method="POST" action="../../index.php?controller=user&action=register">
                    <div class="mb-3">
                        <label for="reg-username" class="form-label">Username</label>
                        <input type="text" class="form-control form-control-lg" id="reg-username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="reg-email" class="form-label">Email Address</label>
                        <input type="email" class="form-control form-control-lg" id="reg-email" name="email" required>
                    </div>
                    <div class="mb-4">
                        <label for="reg-password" class="form-label">Password</label>
                        <input type="password" class="form-control form-control-lg" id="reg-password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-lg w-100">Create Account</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require '../../templates/footer.php' ?>