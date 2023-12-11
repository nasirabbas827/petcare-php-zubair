<?php
session_start();
include('config.php');

// Check if the user is logged in as an admin
if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] !== "admin") {
    header("Location: admin_login.php");
    exit;
}

// Fetch all appointments with user and doctor names
$query = "SELECT Appointments.*, Users.name AS user_name, Doctors.name AS doctor_name
          FROM Appointments
          JOIN Users ON Appointments.user_id = Users.id
          JOIN Users AS Doctors ON Appointments.doctor_id = Doctors.id
          ORDER BY Appointments.created_at DESC";

$result = $conn->query($query);

// Handle appointment status update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['appointment_id'])) {
    $appointment_id = $_POST['appointment_id'];
    $new_status = $_POST['new_status'];

    // Update the appointment status in the database
    $update_query = "UPDATE Appointments SET status = '$new_status' WHERE appointment_id = '$appointment_id'";
    $conn->query($update_query);

    // Redirect to the same page to refresh the appointment list
    header("Location: admin_appointments.php");
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
        .status-form {
            display: inline-block;
        }
    </style>
</head>
<body>
    <?php include('admin_navbar.php'); ?>

    <div class="container">
        <h2 class="mt-4">Admin Dashboard</h2>

        <h3 class="mt-4">All Appointments</h3>
        <?php
        if ($result->num_rows > 0) {
            echo '<table>';
            echo '<tr>';
            echo '<th>Appointment ID</th>';
            echo '<th>User Name</th>';
            echo '<th>Doctor Name</th>';
            echo '<th>Appointment Date</th>';
            echo '<th>Address</th>';
            echo '<th>Payment Method</th>';
            echo '<th>Status</th>';
            echo '<th>Created At</th>';
            echo '<th>Update Status</th>';
            echo '</tr>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['appointment_id'] . '</td>';
                echo '<td>' . $row['user_name'] . '</td>';
                echo '<td>' . $row['doctor_name'] . '</td>';
                echo '<td>' . $row['appointment_date'] . '</td>';
                echo '<td>' . $row['address'] . '</td>';
                echo '<td>' . $row['payment_method'] . '</td>';
                echo '<td>' . $row['status'] . '</td>';
                echo '<td>' . $row['created_at'] . '</td>';
                echo '<td class="status-form">';
                echo '<form method="POST" action="">';
                echo '<input type="hidden" name="appointment_id" value="' . $row['appointment_id'] . '">';
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
            echo '<p>No appointments found.</p>';
        }
        ?>
    </div>
</body>
</html>
