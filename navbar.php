<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">PetsCare</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <?php
            if (isset($_SESSION['user_id'])) {
                // User is logged in
                $user_type = $_SESSION['user_type'];

                // Common links for all user types
                echo '<li class="nav-item"><a class="nav-link" href="' . $user_type . '_dashboard.php">Dashboard (' . $user_type . ')</a></li>';
                echo '<li class="nav-item"><a class="nav-link" href="update_profile.php">Update Profile</a></li>';
                echo '<li class="nav-item"><a class="nav-link" href="feedback.php">Feedbacks</a></li>';
                echo '<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>';

                // User-specific links
                if ($user_type === 'Buyer') {
                    echo '<li class="nav-item"><a class="nav-link" href="buyer_orders.php">Orders</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="view_doctors.php">Doctors</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="view_appointments.php">Appointments</a></li>';
                } elseif ($user_type === 'Seller') {
                    echo '<li class="nav-item"><a class="nav-link" href="add_pets.php">Add Pets for Sale</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="view_orders.php">View Orders</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="view_doctors.php">Doctors</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="view_appointments.php">Appointments</a></li>';
              

                } elseif ($user_type === 'Doctor') {
                    echo '<li class="nav-item"><a class="nav-link" href="doctor_appointments.php">Appointments</a></li>';
                }
            } else {
                // User is not logged in
                echo '<li class="nav-item"><a class="nav-link" href="admin/admin_login.php">Admin Login</a></li>';
                echo '<li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>';
                echo '<li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>';
            }
            ?>
        </ul>
    </div>
</nav>
