<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

$query = "SELECT * FROM Pets";

$result = $conn->query($query);

$pets = array(); // Array to store pet details

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pets[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Buyer View Pets</title>
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
        <h2 class="mt-4">All Pets</h2>
        <div class="row">
            <?php
            if (!empty($pets)) {
                foreach ($pets as $pet) {
                    echo '<div class="col-md-4 mb-4">';
                    echo '<div class="card">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $pet['pet_name'] . '</h5>';
                    echo '<p class="card-text">Type: ' . $pet['pet_type'] . '</p>';
                    echo '<p class="card-text">Description: ' . $pet['pet_description'] . '</p>';
                    echo '<p class="card-text">Price: $' . $pet['pet_price'] . '</p>';
                    echo '<a href="buy_pet.php?pet_id=' . $pet['pet_id'] . '" class="btn btn-primary">Buy</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No pets are currently available.</p>';
            }
            ?>
        </div>
    </div>

</body>
</html>
