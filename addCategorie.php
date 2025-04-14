<?php
require_once '../Controller/CategorieController.php';
require_once(__DIR__ . '/../Model/Config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categorie = new Categorie(
        null,
        $_POST['nom_categorie'],
        $_POST['desc_categorie']
    );

    $categorieController = new CategorieController();
    $categorieController->addCategorie($categorie);

    header('Location: listCategories.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Ajouter une Catégorie</title>

  <link rel="stylesheet" href="../src/assets/vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../src/assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="../src/assets/css/style.css">
  <link rel="shortcut icon" href="../src/assets/images/favicon.ico" />

  <style>
    .form-section {
      max-width: 600px;
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

      <!-- MAIN PANEL -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">

                  <h3 class="text-center mb-4 text-purple">Ajouter une Catégorie</h3>

                  <form method="POST" class="form-section">
                    <div class="form-group">
                      <label for="nom_categorie">Nom de la catégorie</label>
                      <input type="text" class="form-control" id="nom_categorie" name="nom_categorie" required>
                    </div>

                    <div class="form-group">
                      <label for="desc_categorie">Description</label>
                      <textarea class="form-control" id="desc_categorie" name="desc_categorie" rows="4" required></textarea>
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
