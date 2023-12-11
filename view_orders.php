<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

// Fetch seller's added pets and orders
$seller_id = $_SESSION['user_id'];
$query = "SELECT Orders.order_id, Orders.status, Orders.payment_method, Orders.created_at,
                 Pets.pet_name, Pets.pet_type, Pets.pet_price
          FROM Orders
          JOIN Pets ON Orders.pet_id = Pets.pet_id
          WHERE Pets.seller_id = '$seller_id'
          ORDER BY Orders.created_at DESC";

$result = $conn->query($query);

// Handle order status update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];

    // Update the order status in the database
    $update_query = "UPDATE Orders SET status = '$new_status' WHERE order_id = '$order_id'";
    $conn->query($update_query);

    // Redirect to the same page to refresh the order list
    header("Location: view_orders.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Seller Dashboard</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: azure;
        }
        h2, h3 {
            text-align: center;
            margin: 30px;
        }
        table {
            width: 100%;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .status-form {
            display: inline-block;
        }
    </style>
</head>
<body>
    <?php include('navbar.php'); ?>

    <div class="container">
        <h2 class="mt-4">Seller Dashboard</h2>

        <h3 class="mt-4">Your Orders</h3>
        <?php
        if ($result->num_rows > 0) {
            echo '<table>';
            echo '<tr>';
            echo '<th>Order ID</th>';

            echo '<th>Pet Name</th>';
            echo '<th>Pet Type</th>';
            echo '<th>Pet Price</th>';
            echo '<th>Status</th>';
            echo '<th>Payment Method</th>';
            echo '<th>Order Placed on</th>';
            echo '<th>Update Status</th>';
            echo '</tr>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['order_id'] . '</td>';

                echo '<td>' . $row['pet_name'] . '</td>';
                echo '<td>' . $row['pet_type'] . '</td>';
                echo '<td>$' . $row['pet_price'] . '</td>';
                echo '<td>' . $row['status'] . '</td>';
                echo '<td>' . $row['payment_method'] . '</td>';
                echo '<td>' . $row['created_at'] . '</td>';
                echo '<td class="status-form">';
                echo '<form method="POST" action="">';
                echo '<input type="hidden" name="order_id" value="' . $row['order_id'] . '">';
                echo '<div class="form-group">';
                echo '<select name="new_status" class="form-control" required>';
                echo '<option value="pending" ' . ($row['status'] === 'pending' ? 'selected' : '') . '>Pending</option>';
                echo '<option value="approved" ' . ($row['status'] === 'approved' ? 'selected' : '') . '>Approved</option>';
                echo '<option value="cancelled" ' . ($row['status'] === 'cancelled' ? 'selected' : '') . '>Cancelled</option>';
                echo '<option value="paid" ' . ($row['status'] === 'paid' ? 'selected' : '') . '>Paid</option>';
                echo '<option value="not_paid" ' . ($row['status'] === 'not_paid' ? 'selected' : '') . '>Not Paid</option>';
                echo '</select>';
                echo '</div>';
                echo '<button type="submit" class="btn btn-primary">Update</button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<p>No orders found.</p>';
        }
        ?>
    </div>
</body>
</html>
