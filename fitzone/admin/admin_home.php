<?php 
session_start();

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../admin_staff_login.php");
    exit();
}

include 'assists/header_admin.php';
include 'database_connection.php';
?>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            text-align: center;
        }

        .card {
            display: inline-block;
            width: 300px;
            margin: 15px;
            padding: 30px;
            background-color: #464646;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, background-color 0.3s;
            color: #fff;
            font-size: 1.2rem;
            font-weight: bold;
            text-align: center;
            position: relative;
        }

        .card:hover {
            transform: translateY(-5px);
            background-color: #2d2d2d;
        }

        .card .icon {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #ff4c4c;
        }

        .card .count {
            font-size: 2.5rem;
            color: #000;
        }
        /* Popup style */
    .popup {
        position: fixed;
        top: 10%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #ff4c4c;
        color: #333;
        border: 2px solid #333;
        padding: 20px;
        border-radius: 8px;
        font-size: 1.2rem;
        font-weight: bold;
        display: none;
        z-index: 1000;
    }

    .popup.show {
        display: block;
        animation: fadeInOut 4s ease forwards;
    }

    @keyframes fadeInOut {
        0%, 100% { opacity: 0; }
        10%, 90% { opacity: 1; }
    }

    </style>

<div class="container">
<?php
        // Display success message if set
        if (isset($_SESSION['success'])) {
            echo "<div class='popup show'>" . $_SESSION['success'] . "</div>";
            unset($_SESSION['success']); // Clear the message after displaying
        }
?>
<h1>Welcome to the Admin Dashboard</h1>
<p>Overview of the system's key statistics</p>
        <?php

            // Queries for counts
            $totalAdmins = $conn->query("SELECT COUNT(*) as count FROM administration_accounts WHERE role = 'admin'")->fetch_assoc()['count'];
            $totalStaff = $conn->query("SELECT COUNT(*) as count FROM administration_accounts WHERE role = 'staff'")->fetch_assoc()['count'];
            $totalCustomers = $conn->query("SELECT COUNT(*) as count FROM customers")->fetch_assoc()['count'];
            $totalBookings = $conn->query("SELECT COUNT(*) as count FROM bookings")->fetch_assoc()['count'];
            $totalTrainers = $conn->query("SELECT COUNT(*) as count FROM trainers")->fetch_assoc()['count'];
            $totalAppointments = $conn->query("SELECT COUNT(*) as count FROM appointments")->fetch_assoc()['count'];

            // Close connection
            $conn->close();
        ?>

        <!-- Cards with Font Awesome icons -->
        <div class="card">
            <div class="icon"><i class="fas fa-user-shield"></i></div>
            <h3>Total Admins</h3>
            <p><?php echo $totalAdmins; ?></p>
        </div>
        <div class="card">
            <div class="icon"><i class="fas fa-user-tie"></i></div>
            <h3>Total Staff</h3>
            <p><?php echo $totalStaff; ?></p>
        </div>
        <div class="card">
            <div class="icon"><i class="fas fa-users"></i></div>
            <h3>Total Customers</h3>
            <p><?php echo $totalCustomers; ?></p>
        </div>
        <div class="card">
            <div class="icon"><i class="fas fa-calendar-alt"></i></div>
            <h3>Total Bookings</h3>
            <p><?php echo $totalBookings; ?></p>
        </div>
        <div class="card">
            <div class="icon"><i class="fas fa-dumbbell"></i></div>
            <h3>Total Trainers</h3>
            <p><?php echo $totalTrainers; ?></p>
        </div>
        <div class="card">
            <div class="icon"><i class="fas fa-calendar-check"></i></div>
            <h3>Total Appointments</h3>
            <p><?php echo $totalAppointments; ?></p>
        </div>
    </div>

<?php include 'assists/footer_admin.php'; ?>