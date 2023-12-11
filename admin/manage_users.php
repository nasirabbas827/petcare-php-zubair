<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Fetch all users from the database
$query = "SELECT * FROM users";
$result = $conn->query($query);


?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
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
        <h3>All Users</h3>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Age</th>
                    <th>Contact</th>
                    <th>Address</th>
                    <th>User Type</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display user data in a table
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['age'] . "</td>";
                    echo "<td>" . $row['phone_number'] . "</td>";
                    echo "<td>" . $row['address'] . "</td>";
                    echo "<td>" . $row['user_type'] . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    echo "<td><a href='update_status.php?id=" . $row['id'] . "'>Update Status</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    
</body>
</html>
