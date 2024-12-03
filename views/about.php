<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - COOU Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php require '../templates/header.php'; ?>

    <!-- Hero Section -->
    <div class="bg-light py-5">
        <div class="container">
            <div class="text-center">
                <h1 class="display-4 text-success fw-bold">About Us</h1>
                <p class="lead">Welcome to <strong>COOU Library</strong></p>
                <p>Your gateway to knowledge, creativity, and community</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container py-5">
        <!-- Mission Section -->
        <div class="row align-items-center mb-5">
            <div class="col-lg-6">
                <div class="card border-success h-100">
                    <div class="card-body">
                        <h2 class="card-title text-success h3 mb-4">Our Mission</h2>
                        <p class="card-text">
                            At <strong>COOU Library</strong>, our mission is to provide inclusive access to a rich collection 
                            of resources, foster intellectual curiosity, and create a welcoming environment where everyone can thrive. 
                            We aim to inspire innovation, encourage discovery, and contribute to personal and professional growth.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="../assets/cooulib.avif" alt="COOU Library" class="img-fluid rounded shadow-sm">
            </div>
        </div>

        <!-- Services Section -->
        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <div class="card border-success h-100">
                    <div class="card-body">
                        <h2 class="card-title text-success h3 mb-4">What We Offer</h2>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Extensive Collection:</strong> A vast array of books, journals, and digital resources.</li>
                            <li class="list-group-item"><strong>Digital Resources:</strong> Access e-books, online databases, and research tools anytime.</li>
                            <li class="list-group-item"><strong>Study & Collaboration Spaces:</strong> Designed for quiet study or group discussions.</li>
                            <li class="list-group-item"><strong>Programs & Workshops:</strong> Engaging workshops, author talks, and events.</li>
                            <li class="list-group-item"><strong>Student & Faculty Services:</strong> Tailored support for academic and research needs.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-success h-100">
                    <div class="card-body">
                        <h2 class="card-title text-success h3 mb-4">Who We Serve</h2>
                        <p>
                            We proudly serve a diverse community of students, professionals, and lifelong learners.
                            Whether you're seeking academic excellence, personal growth, or recreational reading, 
                            our doors are open to all.
                        </p>
                        <h3 class="text-success h4 mt-4">Our Commitment</h3>
                        <p>
                            We are committed to sustainability, inclusivity, and innovation. By embracing new
                            technologies and evolving user needs, we aim to remain a cornerstone of our 
                            community's growth and development.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Get Involved Section -->
        <div class="card bg-success text-white">
            <div class="card-body text-center py-4">
                <h2 class="card-title h3">Get Involved</h2>
                <p class="card-text mb-0">
                    Join our community today! Volunteer, or attend our events. Let's build a brighter future together.
                </p>
            </div>
        </div>
    </div>

    <?php require '../templates/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>