<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate form data (you may need more validations)
    $feedback = $_POST['feedback'];

    // Insert the feedback into the database
    $query = "INSERT INTO Feedback (user_id, feedback, created_at)
              VALUES ($user_id, '$feedback', NOW())";

    if ($conn->query($query)) {
        // Redirect to a confirmation page or any other page
        echo " Your Feedback Has Been Submitted Thanks For giving Feedback";
       } else {
        echo "Error submitting feedback: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Provide Feedback</title>
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
        <h2>Provide Feedback</h2>

        <form method="POST" action="">
            <div class="form-group">
                <label for="feedback">Your Feedback and Suggestions:</label>
                <textarea id="feedback" name="feedback" class="form-control" rows="5" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit Feedback</button>
        </form>
    </div>
</body>
</html>
