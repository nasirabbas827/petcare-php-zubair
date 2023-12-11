<?php
session_start();
include('config.php');

// Redirect user to their dashboard if already logged in
if (isset($_SESSION['user_id'])) {
    $user_type = $_SESSION['user_type'];
    header("Location: {$user_type}_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>PetsCare</title>
    <!-- Add Bootstrap CDN link here -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <style>
                body{
            background-color:azure;
        }
        h1, h2, h3{
            text-align: center;
            margin: 30px;
        }
        .jumbotron {
            background-color: #3498db; /* Change background color */
            color: white;
            text-align: center;
        }

        .jumbotron h1 {
            font-size: 3rem;
            margin-bottom: 10px;
        }

        .jumbotron p {
            font-size: 1.5rem;
        }

        /* Additional styles for the About PetsCare section */
        .about-section {
            padding: 50px;
        }

        /* Additional styles for statistics */
        .statistics-section {
            background-color: #f2f2f2;
            padding: 20px;
            text-align: center;
        }

        /* Additional styles for the contact form */
        .contact-form {
            padding: 20px;
        }

        /* Additional styles for the footer */
        .footer {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include('navbar.php'); ?>

    <div class="jumbotron text-center">
        <h1>Welcome to PetsCare</h1>
        <p>Your One-Stop Destination for Pets and Veterinary Services</p>
        <a href="login.php" class="btn btn-primary btn-lg">Login to Buy</a>
    </div>

    <div class="container about-section">
        <h2>About PetsCare</h2>
        <p>PetsCare is a dedicated platform for pet lovers, offering a wide range of services and products for your beloved pets. Whether you're looking for veterinary care, pet adoption, or quality pet supplies, PetsCare has you covered.</p>
    </div>
<!-- Display Added Pets Section as Cards -->
<div class="container pets-section">
    <h2>Added Pets</h2>
    <div class="row">
        <?php
        // Fetch and display added pets from the database
        $pets_query = "SELECT * FROM Pets ORDER BY created_at DESC";
        $pets_result = $conn->query($pets_query);

        while ($pet = $pets_result->fetch_assoc()) {
            echo '<div class="col-md-4 mb-3">';
            echo '<div class="card">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $pet['pet_name'] . '</h5>';
            echo '<p class="card-text">Type: ' . $pet['pet_type'] . '</p>';
            echo '<p class="card-text">Description: ' . $pet['pet_description'] . '</p>';
            echo '<p class="card-text">Price: $' . $pet['pet_price'] . '</p>';
            echo '<a href="login.php" class="btn btn-primary">Buy Now</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }

        // If no pets are found
        if ($pets_result->num_rows == 0) {
            echo '<p>No pets found.</p>';
        }
        ?>
    </div>
</div>

<!-- Display Feedbacks Section as Cards -->
<div class="container feedbacks-section">
    <h2>Feedbacks</h2>
    <div class="row">
        <?php
        // Fetch and display feedbacks from the database
        $feedbacks_query = "SELECT Feedback.*, Users.name AS user_name
                            FROM Feedback
                            JOIN Users ON Feedback.user_id = Users.id
                            ORDER BY Feedback.created_at DESC";
        $feedbacks_result = $conn->query($feedbacks_query);

        while ($feedback = $feedbacks_result->fetch_assoc()) {
            echo '<div class="col-md-4 mb-3">';
            echo '<div class="card">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $feedback['user_name'] . '</h5>';
            echo '<p class="card-text">' . $feedback['feedback'] . '</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }

        // If no feedbacks are found
        if ($feedbacks_result->num_rows == 0) {
            echo '<p>No feedbacks found.</p>';
        }
        ?>
    </div>
</div>

    <div class="container statistics-section">
        <h2>Statistics</h2>
        <div class="row">
            <div class="col-md-4">
                <h3>Total Users</h3>
                <p>500,000+</p>
            </div>
            <div class="col-md-4">
                <h3>Total Pets</h3>
                <p>250,000+</p>
            </div>
            <div class="col-md-4">
                <h3>Total Doctors</h3>
                <p>5,000+</p>
            </div>
        </div>
    </div>

    <div class="container contact-form">
        <h2>Contact Us</h2>
        <form>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" placeholder="Your Name">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" placeholder="Your Email">
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea class="form-control" id="message" rows="4" placeholder="Your Message"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <div class="footer">
        <p>&copy; 2023 PetsCare. All rights reserved.</p>
    </div>

</body>
</html>
