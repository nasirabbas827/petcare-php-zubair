<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

$seller_id = $_SESSION['user_id'];

// Fetch pets added by the seller from the database
$query = "SELECT * FROM Pets WHERE seller_id = '$seller_id'";
$result = $conn->query($query);

$seller_pets = array(); // Array to store seller's pets

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $seller_pets[] = $row;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle the form submission to edit or delete a pet
    $pet_id = $_POST['pet_id'];

    if (isset($_POST['edit'])) {
        // Redirect to the edit page for the selected pet
        header("Location: edit_pet.php?pet_id=$pet_id");
        exit();
    } elseif (isset($_POST['delete'])) {
        // Delete the selected pet from the database
        $delete_query = "DELETE FROM Pets WHERE pet_id = '$pet_id'";
        
        if ($conn->query($delete_query) === TRUE) {
            // Pet deleted successfully
            header("Location: seller_pets.php"); // Refresh the page
            exit();
        } else {
            // Handle the case where the deletion fails
            // You can redirect or display an error message
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Seller Dashboard</title>
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
        <h2 class="mt-4">Your Added Pets</h2>
        <?php
        if (!empty($seller_pets)) {
            echo '<table class="table table-striped mt-3">';
            echo '<thead class="thead-dark">';
            echo '<tr>';
            echo '<th>Pet Name</th>';
            echo '<th>Pet Type</th>';
            echo '<th>Description</th>';
            echo '<th>Price</th>';
            echo '<th>Action</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            foreach ($seller_pets as $pet) {
                echo '<tr>';
                echo '<td>' . $pet['pet_name'] . '</td>';
                echo '<td>' . $pet['pet_type'] . '</td>';
                echo '<td>' . $pet['pet_description'] . '</td>';
                echo '<td>$' . $pet['pet_price'] . '</td>';
                echo '<td>';
                echo '<form method="POST">';
                echo '<input type="hidden" name="pet_id" value="' . $pet['pet_id'] . '">';
                echo '<button type="submit" class="btn btn-primary btn-sm" name="edit">Edit</button>';
                echo '<button type="submit" class="btn btn-danger btn-sm" name="delete">Delete</button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<p class="mt-3">You have not added any pets yet.</p>';
        }
        ?>
    </div>

    <!-- Add Bootstrap JavaScript and jQuery (optional) if needed for Bootstrap components -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.0/dist/umd/popper.min.js"></script> -->
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
</body>
</html>
