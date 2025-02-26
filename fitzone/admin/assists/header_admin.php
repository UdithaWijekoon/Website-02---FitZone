<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }
        footer {
            padding: 10px;
            text-align: center;
            margin-top: 50px;
        }
        .sidenav {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            padding-top: 20px;
        }
        .sidenav a, .dropdown-btn {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
            width: 100%;
            text-align: left;
            border: none;
            background: none;
            outline: none;
            cursor: pointer;
        }
        .sidenav a:hover, .dropdown-btn:hover {
            color: #ffc107;
        }
        .dropdown-container {
            display: none;
            background-color: #495057;
            padding-left: 15px;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        @media (max-width: 767px) {
            .sidenav {
                width: 100%;
                height: auto;
                position: relative;
            }
            .sidenav a, .dropdown-btn {
                text-align: center;
            }
            .main-content {
                margin-left: 0;
            }
        } 
    </style>
</head>
<body>

    <!-- Side Navigation Bar -->
    <div class="sidenav">
        <a href="admin_home.php" class="active">Home</a>
        <a href="manage_users.php">Manage Users</a>
        <button class="dropdown-btn">Manage Classes
            <i class="fas fa-caret-down"></i>
        </button>
        <div class="dropdown-container"> 
            <a href="manage_classes.php">Manage Classes</a>
            <a href="manage_class_schedule.php">Manage Class Schedule</a>
            <a href="manage_class_bookings.php">Manage Bookings</a>
        </div>
        <button class="dropdown-btn">Manage Training
            <i class="fas fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
            <a href="manage_trainers.php">Manage Trainers</a>
            <a href="manage_appointments.php">Manage Appointments</a>
        </div>
        <button class="dropdown-btn">Memberships
            <i class="fas fa-caret-down"></i>
        </button>
        <div class="dropdown-container">
            <a href="manage_membership_plans.php">Manage Membership Plans</a>
            <a href="manage_user_memberships.php">User Memberships</a>
        </div>
        <a href="manage_blogs.php">Manage Blogs</a>
        <a href="view_messages.php">View Messages</a>
    </div>
    
    <!-- Main Content -->
    <div class="main-content"> 

        <!-- Header with Dashboard Link and Logout Button -->
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="admin_home.php">Admin Dashboard</a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <form action="admin_logout.php" method="POST" class="d-inline">
                                <button class="btn btn-outline-danger" type="submit">Logout <i class="fas fa-sign-out-alt"></i></button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>