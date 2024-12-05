<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Boostrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"
        defer></script>

    <!-- Bootstrap Icon CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .profile-pic>img {
            border-radius: 40px;
            width: 40px;
            height: 40px;
        }
    </style>
    <title>Document</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand" href="index.php"><img class="w-50 h-50" src="../assets/logo.webp" /></a>

            <!-- Hamburger button for mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Collapsible content -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <div class="navbar-nav ms-3">
                    <a class="nav-link text-white" href="../views/about.php">About</a>
                    <a class="nav-link text-white" href="../views/contact.php">Contact</a>
                </div>
                <div class="navbar-nav ms-auto">
                    <div class="profile-pic">
                        <img src="../assets/profile.png" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><button class="dropdown-item" type="button">Amarachi Kalu</button></li>
                            <li><button class="dropdown-item" type="button"><a href="../views/users/login.php" class="text-decoration-none text-dark">Login</a></button></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><button class="dropdown-item" type="button"><a href="index.php?controller=auth&action=logout" class="text-decoration-none text-dark">Logout</a></button></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</body>

</html>