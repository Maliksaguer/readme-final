<?php
require_once '../Controller/LogementController.php';
require_once(__DIR__ . '/../Model/Config.php');

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Gestion de l'upload d'image
    $imagePath = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $targetDir = "../uploads/";  // Dossier de destination
        // Créer le dossier s'il n'existe pas
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $imagePath = $targetDir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath);
    }

    $logement = new Logement(
        null,
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

    $logementController = new LogementController();
    $logementController->addLogement($logement);

    header('Location: listLogements.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Ajouter un logement</title>

  <link rel="stylesheet" href="../src/assets/vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../src/assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="../src/assets/css/style.css">
  <link rel="shortcut icon" href="../src/assets/images/favicon.ico" />

  <style>
    .form-section {
      max-width: 700px;
      margin: 0 auto;
    }
    .text-purple {
      color: #6f42c1;
    }
  </style>
</head>
<body class="m-0 p-0">
  <div class="container-scroller m-0 p-0">

    <!-- NAVBAR -->
    <nav class="navbar-breadcrumb d-flex flex-row m-0 p-0">
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end m-0 p-0">
        <ul class="navbar-nav navbar-nav-right m-0 p-0">
          <li class="nav-item nav-search d-none d-md-block me-0 m-0 p-0">
            <div class="input-group justify-content-end m-0 p-0">
              <input type="text" class="form-control" placeholder="Search..." aria-label="search">
              <div class="input-group-prepend d-flex">
                <span class="input-group-text"><i class="typcn typcn-zoom"></i></span>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </nav>

    <div class="container-fluid page-body-wrapper m-0 p-0">
      <!-- SIDEBAR -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="index.html">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Dashboard</span>
              <div class="badge badge-danger">new</div>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <i class="typcn typcn-document-text menu-icon"></i>
              <span class="menu-title">Publication</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"><a class="nav-link" href="listPublications.php">Publication</a></li>
                <li class="nav-item"><a class="nav-link" href="listCategories.php">Catégories</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#logements" aria-expanded="false" aria-controls="logements">
              <i class="typcn typcn-home menu-icon"></i>
              <span class="menu-title">Gestion Logement</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="logements">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"><a class="nav-link" href="listLogements.php">Logements</a></li>
                <li class="nav-item"><a class="nav-link" href="listReservations.php">Réservations</a></li>
              </ul>
            </div>
          </li>
        </ul>
      </nav>

      <!-- MAIN PANEL -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">

                  <h3 class="text-purple mb-4 text-center">Ajouter un logement</h3>

                  <form method="POST" enctype="multipart/form-data" class="form-section">
                    <div class="form-group">
                      <label for="titre">Titre</label>
                      <input type="text" class="form-control" id="titre" name="titre" required>
                    </div>

                    <div class="form-group">
                      <label for="description">Description</label>
                      <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                    </div>

                    <div class="form-group">
                      <label for="adresse">Adresse</label>
                      <input type="text" class="form-control" id="adresse" name="adresse" required>
                    </div>

                    <div class="form-group">
                      <label for="ville">Ville</label>
                      <input type="text" class="form-control" id="ville" name="ville" required>
                    </div>

                    <div class="form-group">
                      <label for="type">Type de logement</label>
                      <select class="form-control" id="type" name="type" required>
                        <option value="">-- Choisissez un type --</option>
                        <option value="Appartement">Appartement</option>
                        <option value="Maison">Maison</option>
                        <option value="Villa">Villa</option>
                        <option value="Studio">Studio</option>
                        <option value="Chambre">Chambre</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="prix_par_nuit">Prix par nuit (€)</label>
                      <input type="number" class="form-control" id="prix_par_nuit" name="prix_par_nuit" min="1" step="0.01" required>
                    </div>

                    <div class="form-group">
                      <label for="capacite">Capacité (nombre de personnes)</label>
                      <input type="number" class="form-control" id="capacite" name="capacite" min="1" required>
                    </div>

                    <div class="form-group">
                      <label for="image">Photo du logement</label>
                      <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>

                    <div class="form-check mb-3">
                      <input type="checkbox" class="form-check-input" id="disponibilite" name="disponibilite" checked>
                      <label class="form-check-label" for="disponibilite">Disponible</label>
                    </div>

                    <button type="submit" class="btn btn-success btn-block mt-3">Ajouter</button>
                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- FOOTER -->
        <footer class="footer"></footer>
      </div>
    </div>
  </div>

  <!-- JS Scripts -->
  <script src="../src/assets/vendors/js/vendor.bundle.base.js"></script>
  <script src="../src/assets/js/off-canvas.js"></script>
  <script src="../src/assets/js/hoverable-collapse.js"></script>
  <script src="../src/assets/js/template.js"></script>
  <script src="../src/assets/js/settings.js"></script>
  <script src="../src/assets/js/todolist.js"></script>
</body>
</html>
