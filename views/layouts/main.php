<!DOCTYPE html>
<html>
<head>
    <title>Library Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php?controller=book&action=index">Books</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="index.php?controller=user&action=profile">Profile</a></li>
                <li><a href="index.php?controller=auth&action=logout">Logout</a></li>
            <?php else: ?>
                <li><a href="index.php?controller=auth&action=login">Login</a></li>
                <li><a href="index.php?controller=user&action=register">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert">
            <?php 
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($content)) echo $content; ?>
</body>
</html>
