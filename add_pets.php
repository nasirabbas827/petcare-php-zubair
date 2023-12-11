<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle the form submission to add a pet for sale
    $seller_id = $_SESSION['user_id'];
    $pet_name = $_POST['pet_name'];
    $pet_type = $_POST['pet_type'];
    $pet_description = $_POST['pet_description'];
    $pet_price = $_POST['pet_price'];

    // You should add validation and security measures here before adding to the database

    // Insert the new pet for sale into the database
    $insert_query = "INSERT INTO Pets (seller_id, pet_name, pet_type, pet_description, pet_price) VALUES ('$seller_id', '$pet_name', '$pet_type', '$pet_description', '$pet_price')";
    
    if ($conn->query($insert_query) === TRUE) {
        // Pet added successfully
        header("Location: seller_dashboard.php"); // Redirect to the seller's dashboard
        exit();
    } else {
      }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Pet for Sale</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{
            background-color:azure;
        }
        h1, h2, h3{
            text-align: center;
            margin: 30px;
        }
    </style>
</head>
<body>
    <?php include('navbar.php'); ?>
    <div class="container">
        <h2 class="mt-4">Add a Pet for Sale</h2>
        <form method="POST">
            <div class="form-group">
                <label for="pet_name">Pet Name:</label>
                <input type="text" id="pet_name" name="pet_name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="pet_type">Pet Type:</label>
                <input type="text" id="pet_type" name="pet_type" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="pet_description">Pet Description:</label>
                <textarea id="pet_description" name="pet_description" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label for="pet_price">Pet Price:</label>
                <input type="number" id="pet_price" name="pet_price" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Pet for Sale</button>
        </form>
    </div>

    
</body>
</html>
