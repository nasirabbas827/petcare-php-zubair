<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['doctor_id'])) {
    $doctor_id = $_GET['doctor_id'];

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Sanitize and validate form data (you may need more validations)
        $appointment_date = $_POST['appointment_date'];
        $address = $_POST['address'];

        // Insert the appointment into the database
        $query = "INSERT INTO Appointments (user_id, doctor_id, appointment_date, address, payment_method, status)
                  VALUES ($user_id, $doctor_id, '$appointment_date', '$address', 'cash', 'pending')";

        if ($conn->query($query)) {
            // Redirect to a confirmation page
            header("Location: appointment_confirmation.php");
            exit();
        } else {
            echo "Error creating appointment: " . $conn->error;
        }
    }
} else {
    // Handle the case when no doctor_id is provided
    echo "Invalid request. Please select a doctor to make an appointment.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Appointment</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: azure;
        }
        h2, h3 {
            text-align: center;
            margin: 30px;
        }
        form {
            max-width: 400px;
            margin: auto;
        }
        .form-group {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<?php include('navbar.php'); ?>

    <div class="container">
        <h2>Make Appointment</h2>

        <form method="POST" action="">
            <div class="form-group">
                <label for="appointment_date">Appointment Date & Time:</label>
                <input type="datetime-local" id="appointment_date" name="appointment_date" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <textarea id="address" name="address" class="form-control" rows="3" required></textarea>
            </div>

            <div class="form-group">
                <label for="payment_method">Payment Method:</label>
                <select id="payment_method" name="payment_method" class="form-control" disabled>
                    <option value="cash">Cash</option>
                    <!-- You can add more payment options here -->
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Submit Appointment</button>
        </form>
    </div>
</body>
</html>
