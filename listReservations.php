<?php
require_once '../Controller/ReservationController.php';
$reservationController = new ReservationController();
$liste = $reservationController->listReservations();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Liste des réservations</title>

  <link rel="stylesheet" href="../src/assets/vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../src/assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="../src/assets/css/style.css">
  <link rel="shortcut icon" href="../src/assets/images/favicon.ico" />

  <style>
    .text-purple {
      color: #6f42c1;
    }
    .badge-attente {
      background-color: #ffc107;
      color: #000;
    }
    .badge-confirmee {
      background-color: #28a745;
      color: #fff;
    }
    .badge-annulee {
      background-color: #dc3545;
      color: #fff;
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

      <!-- MAIN CONTENT -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  
                  <!-- Titre en violet au-dessus du tableau -->
                  <h3 class="text-purple mb-4">Liste des réservations</h3>

                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Logement</th>
                        <th>Client</th>
                        <th>Email</th>
                        <th>Date début</th>
                        <th>Date fin</th>
                        <th>Statut</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($liste as $reservation): ?>
                        <tr>
                          <td><?= htmlspecialchars($reservation['id_reservation']) ?></td>
                          <td><?= htmlspecialchars($reservation['titre_logement']) ?></td>
                          <td><?= htmlspecialchars($reservation['nom_client']) ?></td>
                          <td><?= htmlspecialchars($reservation['email_client']) ?></td>
                          <td><?= htmlspecialchars($reservation['date_debut']) ?></td>
                          <td><?= htmlspecialchars($reservation['date_fin']) ?></td>
                          <td>
                            <?php
                            $badgeClass = '';
                            switch (strtolower($reservation['statut'])) {
                                case 'en attente':
                                    $badgeClass = 'badge-attente';
                                    break;
                                case 'confirmée':
                                    $badgeClass = 'badge-confirmee';
                                    break;
                                case 'annulée':
                                    $badgeClass = 'badge-annulee';
                                    break;
                                default:
                                    $badgeClass = 'bg-secondary';
                            }
                            ?>
                            <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($reservation['statut']) ?></span>
                          </td>
                            <td>
                                <a href="updateReservation.php?id=<?= $reservation['id_reservation'] ?>" class="btn btn-primary btn-sm">✏️ Modifier</a>
                                <a href="deleteReservations.php?id=<?= $reservation['id_reservation'] ?>" onclick="return confirm('Supprimer cette réservation ?')" class="btn btn-danger btn-sm">🗑️ Supprimer</a>
                                <div class="btn-group mt-2">
                                    <a href="changeStatus.php?id=<?= $reservation['id_reservation'] ?>&statut=confirmée" class="btn btn-success btn-sm">✓ Confirmer</a>
                                    <a href="changeStatus.php?id=<?= $reservation['id_reservation'] ?>&statut=annulée" class="btn btn-danger btn-sm">✗ Annuler</a>
                                </div>
                            </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>

                  <!-- Bouton Ajouter -->
                  <div class="mt-3">
                    <a href="addReservation.php" class="btn btn-success">➕ Ajouter une réservation</a>
                  </div>

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
  <script src="../src/assets/vendors/chart.js/chart.umd.js"></script>
  <script src="../src/assets/js/jquery.cookie.js"></script>
  <script src="../src/assets/js/off-canvas.js"></script>
  <script src="../src/assets/js/hoverable-collapse.js"></script>
  <script src="../src/assets/js/template.js"></script>
  <script src="../src/assets/js/settings.js"></script>
  <script src="../src/assets/js/todolist.js"></script>
  <script src="../src/assets/js/dashboard.js"></script>
</body>
</html>
