<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$doctor_id = $_SESSION['user_id'];

// Fetch the doctor's appointments with patient names
$query = "SELECT Appointments.*, Users.name AS patient_name FROM Appointments 
          JOIN Users ON Appointments.user_id = Users.id
          WHERE Appointments.doctor_id = $doctor_id 
          ORDER BY Appointments.created_at DESC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Appointments</title>
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
<?php
include('navbar.php');
?> 
    <div class="container">
        <h2>Doctor Appointments</h2>

        <?php
        if ($result->num_rows > 0) {
            while ($appointment = $result->fetch_assoc()) {
                echo '<div class="card">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">Appointment ID: ' . $appointment['appointment_id'] . '</h5>';
                echo '<p>Patient: ' . $appointment['patient_name'] . '</p>';
                echo '<p>Appointment Date & Time: ' . $appointment['appointment_date'] . '</p>';
                echo '<p>Address: ' . $appointment['address'] . '</p>';
                echo '<p>Payment Method: ' . $appointment['payment_method'] . '</p>';
                echo '<p>Status: ' . $appointment['status'] . '</p>';
                echo '<p>Created At: ' . $appointment['created_at'] . '</p>';
                echo '<form method="POST" action="">';
                echo '<input type="hidden" name="appointment_id" value="' . $appointment['appointment_id'] . '">';
                echo '<div class="form-group">';
                echo '<label for="status">Update Status:</label>';
                echo '<select id="status" name="status" class="form-control" required>';
                echo '<option value="pending" ' . ($appointment['status'] === 'pending' ? 'selected' : '') . '>Pending</option>';
                echo '<option value="approved" ' . ($appointment['status'] === 'approved' ? 'selected' : '') . '>Approved</option>';
                echo '<option value="cancelled" ' . ($appointment['status'] === 'cancelled' ? 'selected' : '') . '>Cancelled</option>';
                echo '</select>';
                echo '</div>';
                echo '<button type="submit" class="btn btn-primary">Update Status</button>';
                echo '</form>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>No appointments found.</p>';
        }

        // Handle status update
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newStatus = $_POST['status'];
            $appointmentId = $_POST['appointment_id'];

            // Update the status in the database
            $updateQuery = "UPDATE Appointments SET status = '$newStatus' WHERE appointment_id = $appointmentId";
            $conn->query($updateQuery);

            // Refresh the page to reflect the updated status
            header("Location: doctor_appointments.php");
            exit();
        }
        ?>
    </div>
</body>
</html>
