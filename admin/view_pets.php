<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}


// Query to retrieve pet details and seller's name
$query = "SELECT Pets.*, users.name AS seller_name
          FROM Pets
          INNER JOIN Users ON Pets.seller_id = Users.id";

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
    <title>Admin View Pets</title>
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
    <?php include('admin_navbar.php'); ?>

    <div class="container">
        <h2>All Pets with Sellers</h2>
        <?php
        if (!empty($pets)) {
            echo '<table class="table table-striped">';
            echo '<thead class="thead-dark">';
            echo '<tr>';
            echo '<th>Pet Name</th>';
            echo '<th>Pet Type</th>';
            echo '<th>Description</th>';
            echo '<th>Price</th>';
            echo '<th>Seller Name</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            foreach ($pets as $pet) {
                echo '<tr>';
                echo '<td>' . $pet['pet_name'] . '</td>';
                echo '<td>' . $pet['pet_type'] . '</td>';
                echo '<td>' . $pet['pet_description'] . '</td>';
                echo '<td>$' . $pet['pet_price'] . '</td>';
                echo '<td>' . $pet['seller_name'] . '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<p>No pets found.</p>';
        }
        ?>
    </div>

</body>
</html>
