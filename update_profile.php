<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch the user's current information from the database
$query = "SELECT * FROM Users WHERE id = '$user_id'";
$result = $conn->query($query);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $email = $row['email'];
    $user_type = $row['user_type'];
    $phone_number = $row['phone_number'];
    $address = $row['address'];
    $age = $row['age'];
} else {
    // Handle the case where the user doesn't exist
    // You can redirect or display an error message
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle the form submission to update the user's profile
    $new_name = $_POST['name'];
    $new_email = $_POST['email'];
    $new_phone_number = $_POST['phone_number'];
    $new_address = $_POST['address'];
    $new_age = $_POST['age'];

    // You should add validation and security measures here before updating the database

    // Update the user's profile in the database
    $update_query = "UPDATE Users SET name = '$new_name', email = '$new_email', phone_number = '$new_phone_number', address = '$new_address', age = '$new_age' WHERE id = '$user_id'";
    
    if ($conn->query($update_query) === TRUE) {
        // Profile updated successfully
        header("Location: update_profile.php"); // Redirect to the user's profile page
        exit();
    } else {
        // Handle the case where the update fails
        // You can redirect or display an error message
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Profile</title>
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
    <?php include('navbar.php'); ?>
    <div class="container">
        <h2 class="mt-4">Update Your Profile</h2>
        <form method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo $name; ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo $email; ?>" required>
            </div>

            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="tel" id="phone_number" name="phone_number" class="form-control" value="<?php echo $phone_number; ?>" required>
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" class="form-control" value="<?php echo $address; ?>" required>
            </div>

            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" class="form-control" value="<?php echo $age; ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>

</body>
</html>
