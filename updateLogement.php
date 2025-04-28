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

    header('Location: listLogements.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Modifier un logement</title>

  <link rel="stylesheet" href="../src/assets/vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../src/assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="../src/assets/css/style.css">
  <link rel="shortcut icon" href="../src/assets/images/favicon.ico" />

  <style>
    .form-section {
      max-width: 700px;
      margin: 0 auto;
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
            <div class="col-md-10 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">

                  <h3 class="text-center mb-4 text-primary">Modifier un logement</h3>

                    <form method="POST" enctype="multipart/form-data" class="form-section" id="updateLogementForm">
                        <input type="hidden" name="id_logement" value="<?= $logement['id_logement'] ?>" />
                        <input type="hidden" name="existing_image" value="<?= $logement['image'] ?>" />

                        <div class="form-group">
                            <label for="titre">Titre</label>
                            <input type="text" class="form-control" name="titre" value="<?= htmlspecialchars($logement['titre']) ?>" required minlength="3" maxlength="100" />
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" rows="4" required minlength="10" maxlength="1000"><?= htmlspecialchars($logement['description']) ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="prix_par_nuit">Prix par nuit (€)</label>
                            <input type="number" class="form-control" name="prix_par_nuit" min="1" step="0.01" value="<?= htmlspecialchars($logement['prix_par_nuit']) ?>" required />
                        </div>
                        <button type="submit" class="btn btn-warning btn-block mt-3">Modifier</button>
                    </form>

                    <script>
                        document.getElementById("updateLogementForm").addEventListener("submit", function(event) {
                            let formValid = true;
                        });
                    </script>

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
