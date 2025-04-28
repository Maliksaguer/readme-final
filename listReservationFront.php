<?php
require_once '../Controller/ReservationController.php';
$reservationController = new ReservationController();

// Fetch the list of reservations
$reservations = $reservationController->listReservations();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>WoOx Travel List Reservations</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../templatemo_580_woox_travel/assets/css/animate.css">
    <link rel="stylesheet" href="../templatemo_580_woox_travel/assets/css/fontawesome.css">
    <link rel="stylesheet" href="../templatemo_580_woox_travel/assets/css/templatemo-woox-travel.css">
    <link rel="stylesheet" href="../templatemo_580_woox_travel/assets/css/owl.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

    <!-- Custom Styles for List Reservation -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7f7f7;
        }

        header {
            background-color: #00c4cc;
            padding: 15px 0;
        }

        header .main-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 30px;
        }

        header .main-nav .logo img {
            max-width: 150px;
            height: auto;
        }

        header .main-nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        header .main-nav ul li {
            margin-left: 30px;
        }

        header .main-nav ul li a {
            text-decoration: none;
            color: white;
            font-weight: 600;
            font-size: 16px;
            transition: color 0.3s ease;
        }

        header .main-nav ul li a:hover {
            color: #f9f9f9;
        }

        header .menu-trigger {
            display: none;
            cursor: pointer;
        }

        /* Mobile Menu */
        @media (max-width: 768px) {
            header .main-nav ul {
                display: none;
                width: 100%;
                flex-direction: column;
                align-items: center;
            }

            header .main-nav ul li {
                margin: 10px 0;
            }

            header .menu-trigger {
                display: block;
                font-size: 30px;
                color: white;
            }

            header .main-nav.active ul {
                display: flex;
            }
        }

        /* Table Styles */
        .table {
            width: 100%;
            margin: 40px 0;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table thead {
            background-color: #00c4cc;
            color: white;
        }

        .table th, .table td {
            padding: 15px;
            text-align: center;
            color: #333;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table tbody tr:hover {
            background-color: #e6e6e6;
        }

        .btn {
            border-radius: 5px;
            padding: 5px 10px;
            font-size: 12px;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #00bcd4;
            color: white;
        }

        .btn-danger {
            background-color: #f44336;
            color: white;
        }

        .btn-primary:hover, .btn-danger:hover {
            opacity: 0.8;
        }

        .reservation-form {
            padding: 30px 0;
        }

        footer {
            background-color: #00c4cc;
            color: white;
            text-align: center;
            padding: 10px;
            margin-top: 40px;
        }
    </style>
</head>
<body>

<!-- Header Area -->
<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <a href="index.html" class="logo">
                        <img src="../templatemo_580_woox_travel/assets/images/logo.png" alt="WoOx Logo">
                    </a>
                    <ul class="nav">
                        <li><a href="">Home</a></li>
                        <li><a href="listReservationFront.php">Liste Reservations</a></li>
                        <li><a href="listLogementFront.php">Liste Logements</a></li>
                        <li><a href="addReservationFront.php">Reservation</a></li>
                        <li><a href="addLogementFront.php" class="active">Logement</a></li>
                    </ul>
                    <a class='menu-trigger' onclick="toggleMenu()">
                        <span>Menu</span>
                    </a>
                </nav>
            </div>
        </div>
    </div>
</header>

<!-- Reservation List Table -->
<div class="reservation-form">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h4>Reservation List</h4>

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client Name</th>
                        <th>Client Email</th>
                        <th>Check-in Date</th>
                        <th>Check-out Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($reservations as $reservation): ?>
                        <tr>
                            <td><?= htmlspecialchars($reservation['id_reservation']) ?></td>
                            <td><?= htmlspecialchars($reservation['nom_client']) ?></td>
                            <td><?= htmlspecialchars($reservation['email_client']) ?></td>
                            <td><?= htmlspecialchars($reservation['date_debut']) ?></td>
                            <td><?= htmlspecialchars($reservation['date_fin']) ?></td>
                            <td><?= htmlspecialchars($reservation['statut']) ?></td>
                            <td>
                                <a href="updateReservationFront.php?id=<?= $reservation['id_reservation'] ?>" class="btn btn-primary btn-sm">Modify</a>
                                <a href="deleteReservationFront.php?id=<?= $reservation['id_reservation'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this reservation?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <p>Copyright © 2036 <a href="#">WoOx Travel</a> Company. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="../templatemo_580_woox_travel/vendor/jquery/jquery.min.js"></script>
<script src="../templatemo_580_woox_travel/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="../templatemo_580_woox_travel/assets/js/isotope.min.js"></script>
<script src="../templatemo_580_woox_travel/assets/js/owl-carousel.js"></script>
<script src="../templatemo_580_woox_travel/assets/js/wow.js"></script>
<script src="../templatemo_580_woox_travel/assets/js/tabs.js"></script>
<script src="../templatemo_580_woox_travel/assets/js/popup.js"></script>
<script src="../templatemo_580_woox_travel/assets/js/custom.js"></script>

</body>
</html>
