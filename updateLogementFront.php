<?php
require_once '../Controller/LogementController.php';

$logementController = new LogementController();

if (isset($_GET['id'])) {
    $logement = $logementController->showLogement($_GET['id']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $targetDir = "../uploads/";  // Directory to store uploaded images
        // Create directory if it doesn't exist
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $imagePath = $targetDir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath);
    } else {
        // If no new image is uploaded, keep the existing one
        $imagePath = $_POST['existing_image'];
    }

    // Update logement with the new image path
    $logementController->updateLogement(
        $_POST['id_logement'],
        $_POST['titre'],
        $_POST['description'],
        $_POST['adresse'],
        $_POST['ville'],
        $_POST['type'],
        $_POST['prix_par_nuit'],
        $_POST['capacite'],
        $imagePath,
        isset($_POST['disponibilite']) ? 1 : 0
    );

    header('Location: listLogementFront.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>WoOx Travel Update Logement</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../templatemo_580_woox_travel/assets/css/animate.css">
    <link rel="stylesheet" href="../templatemo_580_woox_travel/assets/css/fontawesome.css">
    <link rel="stylesheet" href="../templatemo_580_woox_travel/assets/css/templatemo-woox-travel.css">
    <link rel="stylesheet" href="../templatemo_580_woox_travel/assets/css/owl.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fc;
            color: #333;
        }

        .header-area {
            background-color: #00c4cc;
            padding: 20px 0;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .header-area .logo img {
            max-width: 150px;
        }

        .header-area .nav {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .header-area .nav li {
            margin: 0 15px;
        }

        .header-area .nav li a {
            text-decoration: none;
            color: white;
            font-size: 16px;
            font-weight: 500;
        }

        .header-area .nav li a:hover {
            color: #FFD700;
        }

        .second-page-heading {
            background-color: #00c4cc;
            padding: 40px 0;
            text-align: center;
            color: white;
        }

        .second-page-heading h4 {
            font-size: 22px;
            margin-bottom: 10px;
        }

        .second-page-heading h2 {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .main-button {
            margin-top: 20px;
        }

        .reservation-form {
            background-color: #fff;
            padding: 40px 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 40px;
        }

        .reservation-form h4 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .reservation-form .form-label {
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .reservation-form input, .reservation-form select, .reservation-form textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        .reservation-form input[type="file"] {
            padding: 8px;
            border: 1px solid #ddd;
            background-color: #f7f7f7;
        }

        .reservation-form input:focus, .reservation-form select:focus, .reservation-form textarea:focus {
            border-color: #00c4cc;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 196, 204, 0.5);
        }

        .reservation-form textarea {
            resize: vertical;
            height: 150px;
        }

        .reservation-form .main-button {
            background-color: #00c4cc;
            color: white;
            padding: 15px 30px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            text-align: center;
        }

        .reservation-form .main-button:hover {
            background-color: #008c8a;
        }

        footer {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
        }

        footer a {
            color: #FFD700;
            text-decoration: none;
        }

        footer a:hover {
            color: #00c4cc;
        }

        @media (max-width: 768px) {
            .reservation-form {
                padding: 20px;
            }
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
                        <img src="../templatemo_580_woox_travel/assets/images/logo.png" alt="">
                    </a>
                    <ul class="nav">
                        <li><a href="">Home</a></li>
                        <li><a href="listReservationFront.php">Liste Reservations</a></li>
                        <li><a href="listLogementFront.php">Liste Logements</a></li>
                        <li><a href="addReservationFront.php">Reservation</a></li>
                        <li><a href="addLogementFront.php" class="active">Logement</a></li>
                    </ul>
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                </nav>
            </div>
        </div>
    </div>
</header>

<!-- Update Logement Form -->
<div class="reservation-form">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <form id="update-logement-form" method="POST" enctype="multipart/form-data" action="updateLogementFront.php">
                    <input type="hidden" name="id_logement" value="<?= htmlspecialchars($logement['id_logement']) ?>">

                    <div class="row">
                        <div class="col-lg-12">
                            <h4>Update Logement</h4>
                        </div>
                        <div class="col-lg-6">
                            <fieldset>
                                <label for="titre" class="form-label">Logement Title</label>
                                <input type="text" name="titre" class="titre" placeholder="Ex. Luxury Villa" value="<?= htmlspecialchars($logement['titre']) ?>" required>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset>
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" class="description" required><?= htmlspecialchars($logement['description']) ?></textarea>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset>
                                <label for="adresse" class="form-label">Address</label>
                                <input type="text" name="adresse" class="adresse" value="<?= htmlspecialchars($logement['adresse']) ?>" required>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset>
                                <label for="ville" class="form-label">City</label>
                                <input type="text" name="ville" class="ville" value="<?= htmlspecialchars($logement['ville']) ?>" required>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset>
                                <label for="type" class="form-label">Type</label>
                                <select name="type" class="form-select" required>
                                    <option value="Appartement" <?= ($logement['type'] == 'Appartement') ? 'selected' : '' ?>>Appartement</option>
                                    <option value="Maison" <?= ($logement['type'] == 'Maison') ? 'selected' : '' ?>>Maison</option>
                                    <option value="Villa" <?= ($logement['type'] == 'Villa') ? 'selected' : '' ?>>Villa</option>
                                    <option value="Studio" <?= ($logement['type'] == 'Studio') ? 'selected' : '' ?>>Studio</option>
                                    <option value="Chambre" <?= ($logement['type'] == 'Chambre') ? 'selected' : '' ?>>Chambre</option>
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset>
                                <label for="prix_par_nuit" class="form-label">Price Per Night (€)</label>
                                <input type="number" name="prix_par_nuit" class="prix_par_nuit" value="<?= htmlspecialchars($logement['prix_par_nuit']) ?>" required>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset>
                                <label for="capacite" class="form-label">Capacity (People)</label>
                                <input type="number" name="capacite" class="capacite" value="<?= htmlspecialchars($logement['capacite']) ?>" required>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset>
                                <label for="image" class="form-label">Image</label>
                                <input type="file" name="image" class="image">
                                <?php if ($logement['image']): ?>
                                    <p>Current Image: <img src="<?= htmlspecialchars($logement['image']) ?>" alt="Current Image" style="max-width: 100px;"></p>
                                <?php endif; ?>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset>
                                <label for="disponibilite" class="form-label">Availability</label>
                                <input type="checkbox" name="disponibilite" <?= ($logement['disponibilite']) ? 'checked' : '' ?>>
                            </fieldset>
                        </div>
                        <div class="col-lg-12">
                            <fieldset>
                                <button class="main-button">Update Logement</button>
                            </fieldset>
                        </div>
                    </div>
                </form>
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
