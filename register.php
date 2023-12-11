<?php
include('config.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];
    $status = 'Pending'; // Set status to "Pending"

    $query = "INSERT INTO users (name, email, password, user_type, status) VALUES ('$name', '$email', '$password', '$user_type', '$status')";
    
    if ($conn->query($query) === TRUE) {
        // Registration successful
        $message = "Registration successful!";
    } else {
        // Registration failed
        $error_message = "Registration failed. Please try again later.";
    }

    // Close database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
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
<?php
include('navbar.php');
?>
    <div class="container">
        <h2>Registration Form</h2>
        
        <?php
        if (isset($message)) {
            echo "<p style='color: green;'>$message</p>";
        }
        if (isset($error_message)) {
            echo "<p style='color: red;'>$error_message</p>";
        }
        ?>

        <form method="post" action="">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            
            <div class="form-group">
                <label for="user_type">User Type:</label>
                <select class="form-control" name="user_type" required>
                    <option value="Doctor">Doctor</option>
                    <option value="Seller">Seller</option>
                    <option value="Buyer">Buyer</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary" name="register">Register</button>
        </form>
    </div>

</body>
</html>
