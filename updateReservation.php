<?php
require_once '../Controller/ReservationController.php';
require_once '../Controller/LogementController.php';

$reservationController = new ReservationController();
$logementController = new LogementController();

if (isset($_GET['id'])) {
    $reservation = $reservationController->showReservation($_GET['id']);
    $logements = $logementController->listLogements();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier les disponibilités uniquement si le logement ou les dates ont changé
    $needAvailabilityCheck = ($_POST['id_logement'] != $reservation['id_logement'] || 
                             $_POST['date_debut'] != $reservation['date_debut'] || 
                             $_POST['date_fin'] != $reservation['date_fin']);
    
    $canUpdate = true;
    if ($needAvailabilityCheck) {
        $canUpdate = $reservationController->checkAvailability(
            $_POST['id_logement'],
            $_POST['date_debut'],
            $_POST['date_fin']
        );
    }

    if ($canUpdate) {
        $reservationController->updateReservation(
            $_POST['id_reservation'],
            $_POST['id_logement'],
            $_POST['nom_client'],
            $_POST['email_client'],
            $_POST['date_debut'],
            $_POST['date_fin'],
            $_POST['statut']
        );

        header('Location: listReservations.php');
        exit();
    } else {
        $error = "Ce logement n'est pas disponible pour les dates sélectionnées.";
        // Recharger les données de réservation et de logements
        $reservation = $reservationController->showReservation($_POST['id_reservation']);
        $logements = $logementController->listLogements();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Modifier une réservation</title>

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

                  <h3 class="text-center mb-4 text-primary">Modifier une réservation</h3>

                  <?php if (isset($error)): ?>
                    <div class="alert alert-danger mb-4">
                      <?= $error ?>
                    </div>
                  <?php endif; ?>

                    <form method="POST" class="form-section" id="updateReservationForm">
                        <input type="hidden" name="id_reservation" value="<?= $reservation['id_reservation'] ?>">

                        <div class="form-group">
                            <label for="nom_client">Nom du client</label>
                            <input type="text" class="form-control" name="nom_client" value="<?= htmlspecialchars($reservation['nom_client']) ?>" required minlength="3" maxlength="100" />
                        </div>


                        <button type="submit" class="btn btn-warning btn-block mt-3">Modifier</button>
                    </form>

                    <script>
                        document.getElementById("updateReservationForm").addEventListener("submit", function(event) {
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
  
  <script>
    // Client-side validation for dates
    document.addEventListener('DOMContentLoaded', function() {
      const dateDebutInput = document.querySelector('input[name="date_debut"]');
      const dateFinInput = document.querySelector('input[name="date_fin"]');
      
      dateDebutInput.addEventListener('change', function() {
        if (dateFinInput.value && dateFinInput.value < dateDebutInput.value) {
          dateFinInput.value = dateDebutInput.value;
        }
      });
    });
  </script>
</body>
</html>
