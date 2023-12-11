<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$buyer_id = $_SESSION['user_id'];

// Fetch buyer's orders from the Orders table
$query = "SELECT Orders.*, Pets.pet_name, Pets.pet_type, Pets.pet_description, Pets.pet_price, Users.name as seller_name
          FROM Orders
          JOIN Pets ON Orders.pet_id = Pets.pet_id
          JOIN Users ON Pets.seller_id = Users.id
          WHERE buyer_id = $buyer_id
          ORDER BY Orders.created_at DESC";

$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{
            background-color: azure;
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
        <h2>My Orders</h2>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="card">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">Order ID: ' . $row['order_id'] . '</h5>';
                echo '<p>Pet Name: ' . $row['pet_name'] . '</p>';
                echo '<p>Pet Type: ' . $row['pet_type'] . '</p>';
                echo '<p>Pet Description: ' . $row['pet_description'] . '</p>';
                echo '<p>Pet Price: $' . $row['pet_price'] . '</p>';
                echo '<p>Seller: ' . $row['seller_name'] . '</p>';
                echo '<p>Status: ' . $row['status'] . '</p>';
                echo '<p>Payment Method: ' . $row['payment_method'] . '</p>';
                echo '<p>Order Placed on: ' . $row['created_at'] . '</p>';
                echo '</div>';
                echo '</div>';
                echo '<br>';
            }
        } else {
            echo '<p>No orders found.</p>';
        }
        ?>
    </div>
</body>
</html>
