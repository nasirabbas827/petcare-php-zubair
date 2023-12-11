<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$buyer_id = $_SESSION['user_id'];

// Fetch all doctors from the Users table with user_type = 'Doctor'
$query = "SELECT * FROM Users WHERE user_type = 'Doctor' AND status = 'Approved'";
$doctorsResult = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Doctors</title>
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
        <h2>View Doctors</h2>

        <?php
        if ($doctorsResult->num_rows > 0) {
            while ($doctor = $doctorsResult->fetch_assoc()) {
                echo '<div class="card">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $doctor['name'] . '</h5>';
                echo '<p>Email: ' . $doctor['email'] . '</p>';
                echo '<p>Phone Number: ' . $doctor['phone_number'] . '</p>';
                echo '<p>Address: ' . $doctor['address'] . '</p>';
                echo '<p>Age: ' . $doctor['age'] . '</p>';
                echo '<p>Status: ' . $doctor['status'] . '</p>';
                echo '<a href="make_appointment.php?doctor_id=' . $doctor['id'] . '" class="btn btn-primary">Make Appointment</a>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>No doctors found.</p>';
        }
        ?>
    </div>
</body>
</html>
