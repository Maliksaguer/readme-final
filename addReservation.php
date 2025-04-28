<?php
require_once '../Controller/ReservationController.php';
require_once '../Controller/LogementController.php';
require_once(__DIR__ . '/../Model/Config.php');

$logementController = new LogementController();
$reservationController = new ReservationController();
$logements = $logementController->listAvailableLogements();

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si les dates sont disponibles pour ce logement
    $isAvailable = $reservationController->checkAvailability(
        $_POST['id_logement'],
        $_POST['date_debut'],
        $_POST['date_fin']
    );

    if ($isAvailable) {
        $reservation = new Reservation(
            null,
            $_POST['id_logement'],
            $_POST['nom_client'],
            $_POST['email_client'],
            $_POST['date_debut'],
            $_POST['date_fin'],
            $_POST['statut']
        );

        $reservationController->addReservation($reservation);

        header('Location: listReservations.php');
        exit();
    } else {
        $error = "Ce logement n'est pas disponible pour les dates sélectionnées.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Ajouter une réservation</title>

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

                  <h3 class="text-purple mb-4 text-center">Ajouter une réservation</h3>

                  <?php if (isset($error)): ?>
                    <div class="alert alert-danger mb-4">
                      <?= $error ?>
                    </div>
                  <?php endif; ?>

                    <form method="POST" class="form-section" id="addReservationForm">
                        <div class="form-group">
                            <label for="id_logement">Logement</label>
                            <select class="form-control" id="id_logement" name="id_logement" required>
                                <option value="">-- Choisissez un logement --</option>
                                <?php foreach ($logements as $logement): ?>
                                    <option value="<?= $logement['id_logement'] ?>"><?= htmlspecialchars($logement['titre']) ?> - <?= htmlspecialchars($logement['ville']) ?> (<?= htmlspecialchars($logement['prix_par_nuit']) ?> €/nuit)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="nom_client">Nom du client</label>
                            <input type="text" class="form-control" id="nom_client" name="nom_client" required minlength="3" maxlength="100" />
                        </div>

                        <div class="form-group">
                            <label for="email_client">Email du client</label>
                            <input type="email" class="form-control" id="email_client" name="email_client" required />
                        </div>

                        <div class="form-group">
                            <label for="date_debut">Date d'arrivée</label>
                            <input type="date" class="form-control" id="date_debut" name="date_debut" required />
                        </div>

                        <div class="form-group">
                            <label for="date_fin">Date de départ</label>
                            <input type="date" class="form-control" id="date_fin" name="date_fin" required />
                        </div>

                        <div class="form-group">
                            <label for="statut">Statut</label>
                            <select class="form-control" id="statut" name="statut" required>
                                <option value="en attente">En attente</option>
                                <option value="confirmée">Confirmée</option>
                                <option value="annulée">Annulée</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success btn-block mt-3">Ajouter</button>
                    </form>

                    <script>
                        document.getElementById("addReservationForm").addEventListener("submit", function(event) {
                            let formValid = true;
                            const nomClient = document.getElementById("nom_client");
                            if (nomClient.value.length < 3 || nomClient.value.length > 100) {
                                alert("Le nom du client doit avoir entre 3 et 100 caractères.");
                                formValid = false;
                            }
                            const emailClient = document.getElementById("email_client");
                            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                            if (!emailRegex.test(emailClient.value)) {
                                alert("Veuillez entrer un email valide.");
                                formValid = false;
                            }
                            const dateDebut = document.getElementById("date_debut");
                            const dateFin = document.getElementById("date_fin");
                            if (new Date(dateFin.value) < new Date(dateDebut.value)) {
                                alert("La date de départ doit être après la date d'arrivée.");
                                formValid = false;
                            }
                            if (!formValid) {
                                event.preventDefault();
                            }
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
    // Client-side validation for dates (ensure date_fin is after date_debut)
    document.addEventListener('DOMContentLoaded', function() {
      const dateDebutInput = document.getElementById('date_debut');
      const dateFinInput = document.getElementById('date_fin');

      dateDebutInput.addEventListener('change', function() {
        dateFinInput.min = dateDebutInput.value;
        if (dateFinInput.value && dateFinInput.value < dateDebutInput.value) {
          dateFinInput.value = dateDebutInput.value;
        }
      });

      // Set min date to today
      const today = new Date().toISOString().split('T')[0];
      dateDebutInput.min = today;
      if (!dateDebutInput.value) {
        dateFinInput.min = today;
      }
    });
  </script>
</body>
</html>
