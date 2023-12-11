<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Fetch all feedbacks with user names
$query = "SELECT Feedback.*, Users.name AS user_name
          FROM Feedback
          JOIN Users ON Feedback.user_id = Users.id
          ORDER BY Feedback.created_at DESC";

$result = $conn->query($query);

// Handle feedback deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['feedback_id'])) {
    $feedback_id = $_POST['feedback_id'];

    // Delete the feedback from the database
    $delete_query = "DELETE FROM Feedback WHERE feedback_id = '$feedback_id'";
    $conn->query($delete_query);

    // Redirect to the same page to refresh the feedback list
    header("Location: admin_feedbacks.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
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
        .delete-form {
            display: inline-block;
        }
    </style>
</head>
<body>
    <?php include('admin_navbar.php'); ?>

    <div class="container">
        <h2 class="mt-4">Admin Dashboard</h2>

        <h3 class="mt-4">All Feedbacks</h3>
        <?php
        if ($result->num_rows > 0) {
            echo '<table>';
            echo '<tr>';
            echo '<th>Feedback ID</th>';
            echo '<th>User Name</th>';
            echo '<th>Feedback</th>';
            echo '<th>Created At</th>';
            echo '<th>Delete Feedback</th>';
            echo '</tr>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['feedback_id'] . '</td>';
                echo '<td>' . $row['user_name'] . '</td>';
                echo '<td>' . $row['feedback'] . '</td>';
                echo '<td>' . $row['created_at'] . '</td>';
                echo '<td class="delete-form">';
                echo '<form method="POST" action="">';
                echo '<input type="hidden" name="feedback_id" value="' . $row['feedback_id'] . '">';
                echo '<button type="submit" class="btn btn-danger">Delete</button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<p>No feedbacks found.</p>';
        }
        ?>
    </div>
</body>
</html>
