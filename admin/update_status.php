<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}


// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $new_status = 'Approved'; // Set the new status as 'Approved' or any desired status

    // Update the user's status in the database
    $query = "UPDATE users SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $new_status, $user_id);
    
    if ($stmt->execute()) {
        header("Location: manage_users.php"); // Redirect back to admin panel after updating
        exit();
    } else {
        echo "Error updating user status. Please try again.";
    }
} else {
    echo "User ID not provided.";
}
?>
