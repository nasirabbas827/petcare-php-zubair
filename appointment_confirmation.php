<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch the latest appointment for the logged-in user
$query = "SELECT * FROM Appointments WHERE user_id = $user_id ORDER BY created_at DESC LIMIT 1";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $appointment = $result->fetch_assoc();
} else {
    // Handle the case when no appointment is found
    echo "No appointment found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Confirmation</title>
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
            max-width: 400px;
            margin: auto;
            margin-top: 50px;
        }
        .card-body {
            text-align: left;
        }
    </style>
</head>
<body>
<?php include('navbar.php'); ?>

    <div class="container">
        <h2>Appointment Confirmation</h2>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Appointment ID: <?php echo $appointment['appointment_id']; ?></h5>
                <p>Doctor ID: <?php echo $appointment['doctor_id']; ?></p>
                <p>Appointment Date & Time: <?php echo $appointment['appointment_date']; ?></p>
                <p>Address: <?php echo $appointment['address']; ?></p>
                <p>Payment Method: <?php echo $appointment['payment_method']; ?></p>
                <p>Status: <?php echo $appointment['status']; ?></p>
                <p>Created At: <?php echo $appointment['created_at']; ?></p>
            </div>
        </div>
    </div>
</body>
</html>
