<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['pet_id'])) {
    $pet_id = $_GET['pet_id'];

    // Fetch pet details from the database
    $query = "SELECT Pets.*, Users.name as seller_name, Users.email as seller_email, Users.phone_number as seller_phone, Users.address as seller_address
              FROM Pets
              JOIN Users ON Pets.seller_id = Users.id
              WHERE pet_id = $pet_id";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $petDetails = $result->fetch_assoc();

        // Fetch buyer details from the database (assuming the user is logged in)
        $buyer_id = $_SESSION['user_id'];
        $buyer_query = "SELECT name, email, address FROM Users WHERE id = $buyer_id";
        $buyer_result = $conn->query($buyer_query);

        if ($buyer_result->num_rows > 0) {
            $buyerDetails = $buyer_result->fetch_assoc();
        } else {
            echo '<p>Buyer details not found.</p>';
            exit(); // Exit if buyer details are not found
        }
    } else {
        echo '<p>Pet not found.</p>';
        exit(); // Exit if pet details are not found
    }
} else {
    echo '<p>Invalid request.</p>';
    exit(); // Exit if pet_id is not set
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Pet</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{
            background-color: azure;
        }
        h1, h2, h3{
            text-align: center;
            margin: 30px;
        }
    </style>
</head>
<body>
    <div class="container mb-5">
        <h2><?php echo $petDetails['pet_name']; ?></h2>
        <p>Type: <?php echo $petDetails['pet_type']; ?></p>
        <p>Description: <?php echo $petDetails['pet_description']; ?></p>
        <p>Price: $<?php echo $petDetails['pet_price']; ?></p>
        <p>Seller: <?php echo $petDetails['seller_name']; ?></p>
        <p>Seller Email: <?php echo $petDetails['seller_email']; ?></p>
        <p>Seller Phone: <?php echo $petDetails['seller_phone']; ?></p>
        <p>Seller Address: <?php echo $petDetails['seller_address']; ?></p>

        <!-- Display buyer details -->
        <h3>Your Details</h3>
        <p>Your Name: <?php echo $buyerDetails['name']; ?></p>
        <p>Your Email: <?php echo $buyerDetails['email']; ?></p>
        <p>Your Address: <?php echo $buyerDetails['address']; ?></p>

        <!-- Form for the buyer to submit their information -->
        <form action="process_purchase.php" method="post">
            <input type="hidden" name="pet_id" value="<?php echo $pet_id; ?>">
            <input type="hidden" name="buyer_id" value="<?php echo $buyer_id; ?>">
            <input type="hidden" name="status" value="Pending">

            <!-- Payment method field -->
            <div class="form-group">
                <label for="payment_method">Payment Method:</label>
                <select class="form-control" id="payment_method" name="payment_method">
                    <option value="cash_on_delivery">Cash on Delivery</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Purchase</button>
        </form>
    </div>
</body>
</html>
