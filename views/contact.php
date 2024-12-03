<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - COOU Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php require '../templates/header.php'; ?>

    <!-- Hero Section -->
    <div class="bg-light py-5">
        <div class="container">
            <div class="text-center">
                <h1 class="display-4 text-success fw-bold">Contact Us</h1>
                <p class="lead">Get in touch with the COOU Library team</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container py-5">
        <div class="row g-4">
            <!-- Contact Information -->
            <div class="col-lg-4">
                <div class="card border-success h-100">
                    <div class="card-body">
                        <h2 class="card-title text-success h3 mb-4">Contact Information</h2>
                        <div class="d-flex mb-3">
                            <i class="fas fa-map-marker-alt text-success me-3 mt-1"></i>
                            <div>
                                <h3 class="h6 mb-1">Address</h3>
                                <p class="mb-0">Chukwuemeka Odumegwu Ojukwu University Library<br>
                                Igbariam Campus, Anambra State</p>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <i class="fas fa-phone text-success me-3 mt-1"></i>
                            <div>
                                <h3 class="h6 mb-1">Phone</h3>
                                <p class="mb-0">+234 123 456 7890</p>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <i class="fas fa-envelope text-success me-3 mt-1"></i>
                            <div>
                                <h3 class="h6 mb-1">Email</h3>
                                <p class="mb-0">library@coou.edu.ng</p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <i class="fas fa-clock text-success me-3 mt-1"></i>
                            <div>
                                <h3 class="h6 mb-1">Opening Hours</h3>
                                <p class="mb-0">Monday - Friday: 8:00 AM - 6:00 PM<br>
                                Saturday: 9:00 AM - 2:00 PM<br>
                                Sunday: Closed</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-8">
                <div class="card border-success">
                    <div class="card-body">
                        <h2 class="card-title text-success h3 mb-4">Send us a Message</h2>
                        <form>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" required>
                                </div>
                                <div class="col-12">
                                    <label for="subject" class="form-label">Subject</label>
                                    <input type="text" class="form-control" id="subject" required>
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea class="form-control" id="message" rows="5" required></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-success">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map Section -->
        <div class="card border-success mt-4">
            <div class="card-body">
                <h2 class="card-title text-success h3 mb-4">Our Location</h2>
                <div class="ratio ratio-21x9">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.8734087689747!2d6.8940844!3d6.4170984!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1043f38f43a5554d%3A0x44afc26f586548e1!2sChukwuemeka%20Odumegwu%20Ojukwu%20University!5e0!3m2!1sen!2sng!4v1645554058374!5m2!1sen!2sng" 
                            style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>

    <?php require '../templates/footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 