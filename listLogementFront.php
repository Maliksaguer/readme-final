<?php
// listLogementFront.php
require_once '../Controller/LogementController.php';
$logementController = new LogementController();
$logements = $logementController->listLogements();  // Fetch all logements
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>WoOx Travel List Logement Page</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../templatemo_580_woox_travel/assets/css/animate.css">
    <link rel="stylesheet" href="../templatemo_580_woox_travel/assets/css/fontawesome.css">
    <link rel="stylesheet" href="../templatemo_580_woox_travel/assets/css/templatemo-woox-travel.css">
    <link rel="stylesheet" href="../templatemo_580_woox_travel/assets/css/owl.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

    <style>
        /* Additional custom styles */
        .logement-list-table th, .logement-list-table td {
            padding: 15px;
            text-align: center;
        }

        .logement-list-table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .logement-list-table th {
            background-color: #00c4cc;
            color: white;
        }

        .logement-list-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .logement-list-table td {
            border: 1px solid #ddd;
        }

        .logement-list-table td img {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
        }

        .btn-edit, .btn-delete {
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
            font-size: 14px;
        }

        .btn-edit {
            background-color: #00c4cc;
            color: white;
            border: none;
        }

        .btn-edit:hover {
            background-color: #008c8a;
        }

        .btn-delete {
            background-color: #ff4e4e;
            color: white;
            border: none;
        }

        .btn-delete:hover {
            background-color: #ff1a1a;
        }

        .table-container {
            margin-top: 40px;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .table-container h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
        }
         .logement-list-table td {
            padding: 15px;
            text-align: center;
            color: black; /* Set text color to black */
        }
         .table-container h2{
             padding-top: 100px;
         }
        /* Navbar styles */
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

        /* Add a hover effect for the menu trigger */
        header .menu-trigger {
            display: none;
            cursor: pointer;
        }

        /* For smaller screens */
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

    </style>
</head>
<body>

<!-- Header Area -->
<!-- Header Area -->
<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- Logo -->
                    <a href="" class="logo">
                        <img src="../templatemo_580_woox_travel/assets/images/logo.png" alt="WoOx Logo">
                    </a>

                    <!-- Menu -->
                    <ul class="nav">
                        <li><a href="">Home</a></li>
                        <li><a href="listReservationFront.php">Liste Reservations</a></li>
                        <li><a href="listLogementFront.php">Liste Logements</a></li>
                        <li><a href="addReservationFront.php">Reservation</a></li>
                        <li><a href="addLogementFront.php" class="active">Logement</a></li>
                    </ul>

                    <!-- Mobile Menu Trigger -->
                    <a class="menu-trigger" onclick="toggleMenu()">
                        <span>Menu</span>
                    </a>
                </nav>
            </div>
        </div>
    </div>
</header>

<!-- Navbar Script -->
<script>
    function toggleMenu() {
        document.querySelector('.main-nav').classList.toggle('active');
    }
</script>


<!-- List Logement Table -->
<div class="container table-container">
    <h2>List of Logements</h2>
    <table class="logement-list-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Title</th>
            <th>City</th>
            <th>Type</th>
            <th>Price Per Night</th>
            <th>Capacity</th>
            <th>Availability</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($logements as $logement): ?>
            <tr>
                <td><?= htmlspecialchars($logement['id_logement']) ?></td>
                <td>
                    <?php if ($logement['image']): ?>
                        <img src="<?= htmlspecialchars($logement['image']) ?>" alt="Logement Image">
                    <?php else: ?>
                        <span>No Image</span>
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($logement['titre']) ?></td>
                <td><?= htmlspecialchars($logement['ville']) ?></td>
                <td><?= htmlspecialchars($logement['type']) ?></td>
                <td><?= htmlspecialchars($logement['prix_par_nuit']) ?> €</td>
                <td><?= htmlspecialchars($logement['capacite']) ?> persons</td>
                <td>
                    <?php if ($logement['disponibilite']): ?>
                        <span class="badge bg-success">Available</span>
                    <?php else: ?>
                        <span class="badge bg-danger">Not Available</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="updateLogementFront.php?id=<?= $logement['id_logement'] ?>" class="btn-edit">Modify</a>
                    <a href="deleteLogementFront.php?id=<?= $logement['id_logement'] ?>" onclick="return confirm('Are you sure you want to delete this logement?')" class="btn-delete">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <p>Copyright © 2025 <a href="#"></a> Company. All rights reserved.
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
