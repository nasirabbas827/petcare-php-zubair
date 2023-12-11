<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch the user's appointments
$query = "SELECT * FROM Appointments WHERE user_id = $user_id ORDER BY created_at DESC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Appointments</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: azure;
        }
        h2, h3 {
            text-align: center;
            margin: 30px;
        }
        .card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<?php include('navbar.php'); ?>

    <div class="container">
        <h2>View Appointments</h2>

        <?php
        if ($result->num_rows > 0) {
            while ($appointment = $result->fetch_assoc()) {
                echo '<div class="card">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">Appointment ID: ' . $appointment['appointment_id'] . '</h5>';
                echo '<p>Doctor ID: ' . $appointment['doctor_id'] . '</p>';
                echo '<p>Appointment Date & Time: ' . $appointment['appointment_date'] . '</p>';
                echo '<p>Address: ' . $appointment['address'] . '</p>';
                echo '<p>Payment Method: ' . $appointment['payment_method'] . '</p>';
                echo '<p>Status: ' . $appointment['status'] . '</p>';
                echo '<p>Created At: ' . $appointment['created_at'] . '</p>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>No appointments found.</p>';
        }
        ?>
    </div>
</body>
</html>
