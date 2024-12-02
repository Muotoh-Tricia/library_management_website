<div class="container mt-5">
    <div class="row">
        <!-- Profile Card -->
        <div class="col-md-4">
            <div class="card border-success mb-4">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Profile</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <img src="https://via.placeholder.com/150" class="rounded-circle" alt="Profile Picture">
                    </div>
                    <h5 class="card-title text-center"><?php echo htmlspecialchars($_SESSION['username']); ?></h5>
                    <p class="text-muted text-center"><?php echo htmlspecialchars($_SESSION['role']); ?></p>
                </div>
            </div>
        </div>

        <!-- Update Profile Form -->
        <div class="col-md-8">
            <div class="card border-success">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Update Profile</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="index.php?controller=user&action=updateProfile">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username:</label>
                            <input type="text" class="form-control" id="username" name="username" 
                                   value="<?php echo htmlspecialchars($_SESSION['username']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo htmlspecialchars($_SESSION['email']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password (leave blank to keep current):</label>
                            <input type="password" class="form-control" id="new_password" name="new_password">
                        </div>
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password (required to save changes):</label>
                            <input type="password" class="form-control" id="current_password" name="current_password">
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">Update Profile</button>
                            <a href="index.php?controller=auth&action=logout" class="btn btn-outline-danger">Logout</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Borrowing History -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-success">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Borrowing History</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Book Title</th>
                                    <th>Borrow Date</th>
                                    <th>Return Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php // Add your borrowing history data here ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 