<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['pet_id'])) {
    $pet_id = $_GET['pet_id'];
    
    // Fetch pet details from the database
    $query = "SELECT * FROM Pets WHERE pet_id = '$pet_id'";
    $result = $conn->query($query);
    
    if ($result->num_rows == 1) {
        $pet = $result->fetch_assoc();
    } else {
        // Pet not found, handle the error (e.g., redirect to a pet listing page)
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle the form submission to update pet details
    $pet_id = $_POST['pet_id'];
    $new_pet_name = $_POST['pet_name'];
    $new_pet_type = $_POST['pet_type'];
    $new_pet_description = $_POST['pet_description'];
    $new_pet_price = $_POST['pet_price'];
    
    // Update the pet details in the database
    $update_query = "UPDATE Pets 
                     SET pet_name = '$new_pet_name', 
                         pet_type = '$new_pet_type', 
                         pet_description = '$new_pet_description', 
                         pet_price = '$new_pet_price' 
                     WHERE pet_id = '$pet_id'";
    
    if ($conn->query($update_query) === TRUE) {
        // Pet details updated successfully
        header("Location: seller_pets.php"); // Redirect to the pet listing page
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
    <title>Edit Pet</title>
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
        <h2 class="mt-4">Edit Pet</h2>
        <form method="POST">
            <input type="hidden" name="pet_id" value="<?php echo $pet['pet_id']; ?>">
            
            <div class="form-group">
                <label for="pet_name">Pet Name:</label>
                <input type="text" name="pet_name" id="pet_name" class="form-control" value="<?php echo $pet['pet_name']; ?>">
            </div>
            
            <div class="form-group">
                <label for="pet_type">Pet Type:</label>
                <input type="text" name="pet_type" id="pet_type" class="form-control" value="<?php echo $pet['pet_type']; ?>">
            </div>
            
            <div class="form-group">
                <label for="pet_description">Description:</label>
                <textarea name="pet_description" id="pet_description" class="form-control"><?php echo $pet['pet_description']; ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="pet_price">Price:</label>
                <input type="text" name="pet_price" id="pet_price" class="form-control" value="<?php echo $pet['pet_price']; ?>">
            </div>
            
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>

</body>
</html>
