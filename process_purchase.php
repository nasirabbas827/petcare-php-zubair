<?php
session_start();
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input data (you may need more robust validation)
    $pet_id = $_POST['pet_id'];
    $buyer_id = $_POST['buyer_id'];
    $payment_method = $_POST['payment_method'];

    // Insert order details into the Orders table with status set to "Pending"
    $insertOrderQuery = "INSERT INTO Orders (pet_id, buyer_id, status, payment_method) VALUES ('$pet_id', '$buyer_id', 'Pending', '$payment_method')";
    $conn->query($insertOrderQuery);

    // Display a message
    echo "Your order with Cash on Delivery has been placed. Please wait for admin or seller approval.";

    // You can also provide a link to go back to the home page or any other appropriate action
    echo '<br><a href="buyer_dashboard.php">Go back to home page</a>';
} else {
    // If someone tries to access the page without submitting the form, redirect to the home page
    header("Location: index.php");
    exit();
}
?>
