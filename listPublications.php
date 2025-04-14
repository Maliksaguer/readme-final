<?php
require_once __DIR__ . '/../Controller/publication.php';

$publication = new publication();
$liste = $publication->listPublications();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Liste des publications</title>

  <link rel="stylesheet" href="../src/assets/vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../src/assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="../src/assets/css/style.css">
  <link rel="shortcut icon" href="../src/assets/images/favicon.ico" />

  <style>
    .text-purple {
      color: #6f42c1;
    }
    .img-thumbnail {
      max-width: 100px;
      max-height: 100px;
      object-fit: cover;
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
              <span class="menu-title">publication</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"><a class="nav-link" href="listPublications.php">publication</a></li>
                <li class="nav-item"><a class="nav-link" href="listCategories.php">categories</a></li>
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

                  <!-- Titre en violet -->
                  <h3 class="text-purple mb-4">Liste des publications</h3>

                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Titre</th>
                        <th>Contenu</th>
                        <th>Image</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th>Catégorie</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($liste as $pub): ?>
                        <tr>
                          <td><?= htmlspecialchars($pub['id_publication']) ?></td>
                          <td><?= htmlspecialchars($pub['titre']) ?></td>
                          <td><?= htmlspecialchars($pub['contenu']) ?></td>
                          <td>
                            <?php if (!empty($pub['image']) && file_exists(__DIR__ . '/path_to_images/' . $pub['image'])): ?>
                              <img src="<?= htmlspecialchars($pub['image']) ?>" class="img-thumbnail" alt="Image publication">
                            <?php else: ?>
                              <span>Aucune image</span>
                            <?php endif; ?>
                          </td>
                          <td><?= htmlspecialchars($pub['statut']) ?></td>
                          <td><?= htmlspecialchars($pub['date']) ?></td>
                          <td>
                            <?= isset($pub['nom_categorie']) ? htmlspecialchars($pub['nom_categorie']) : 'ID: ' . htmlspecialchars($pub['id_categorie']) ?>
                          </td>
                          <td>
                            <a href="updatePublication.php?id=<?= $pub['id_publication'] ?>" class="btn btn-primary btn-sm">✏️ Modifier</a>
                            <a href="deletePublication.php?id=<?= $pub['id_publication'] ?>" onclick="return confirm('Supprimer cette publication ?')" class="btn btn-danger btn-sm">🗑️ Supprimer</a>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>

                  <!-- Bouton Ajouter -->
                  <div class="mt-3">
                    <a href="addPublication.php" class="btn btn-success">➕ Ajouter une publication</a>
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
