<?php
session_start(); 
?>
<!-- header.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitZone Fitness Center</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Navbar Styles */
        .navbar {
            background-color: #1a1a1a;
            padding: 15px 0; 
            animation: fadeInDown 1s ease-in-out; 
        }
        .navbar-brand {
            color: #ff4c4c;
            font-weight: bold;
        }
        .navbar-nav .nav-link {
            color: white;
            transition: color 0.3s ease-in-out;
        }
        .navbar-nav .nav-link:hover {
            color: #ff4c4c;
        }
        .navbar-toggler {
            border-color: #ff4c4c;
        }
        .btn-login {
            background-color: #ff4c4c;
            border-color: #ff4c4c;
            color: white;
            transition: background-color 0.3s ease;
            margin-left: 10px;
        }
        .btn-login:hover {
            background-color: #831111;
            color: white;
        }
        /* Red line below navbar */
        .red-line {
            height: 3px; 
            background-color: #ff4c4c; 
            width: 100%; 
        }
        /* Animation Keyframes */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">FitZone Fitness Center</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="classes.php">Classes</a></li>
                <li class="nav-item"><a class="nav-link" href="personal_training.php">Personal Training</a></li>
                <li class="nav-item"><a class="nav-link" href="membership.php">Membership</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="blog.php">Blog</a></li>
                <?php if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true): ?>
                        <!-- Show Logout if user is logged in -->
                        <li>
                            <a class=" btn btn-login" href="customer_logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <!-- Show Login if user is not logged in -->
                        <li>
                            <a class=" btn btn-login" href="customer_login.php">Login</a>
                        </li>
                    <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<div class="red-line"></div>
