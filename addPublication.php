<?php
require_once '../Controller/publication.php';
require_once(__DIR__ . '/../Model/Config.php');
require_once '../Controller/CategorieController.php';

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Gestion de l'upload d'image
    $imagePath = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $targetDir = "../uploads/";  // Dossier de destination
        $imagePath = $targetDir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath);
    }

    $publication = new PublicationClass(
        null,
        $_POST['titre'],
        $_POST['contenu'],
        $imagePath,  // Enregistrer le chemin de l'image téléchargée
        $_POST['statut'],
        $_POST['date'],
        $_POST['id_categorie']
    );

    $publicationController = new publication();
    $publicationController->addPublication($publication);

    header('Location: listPublications.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Ajouter une Publication</title>

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

                  <h3 class="text-purple mb-4 text-center">Ajouter une Publication</h3>

                  <form method="POST" enctype="multipart/form-data" class="form-section">
                    <div class="form-group">
                      <label for="titre">Titre</label>
                      <input type="text" class="form-control" id="titre" name="titre" required>
                    </div>

                    <div class="form-group">
                      <label for="contenu">Contenu</label>
                      <textarea class="form-control" id="contenu" name="contenu" rows="4" required></textarea>
                    </div>

                    <div class="form-group">
                      <label for="image">Choisir une image</label>
                      <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>

                    <div class="form-group">
                      <label for="statut">Statut</label>
                      <input type="text" class="form-control" id="statut" name="statut" required>
                    </div>

                    <div class="form-group">
                      <label for="date">Date</label>
                      <input type="date" class="form-control" id="date" name="date" required>
                    </div>

                    <div class="form-group">
                      <label for="id_categorie">Catégorie</label>
                      <select class="form-control" id="id_categorie" name="id_categorie" required>
                        <option value="">-- Choisissez une catégorie --</option>
                        <?php
                        $catController = new CategorieController();
                        $categories = $catController->listCategories();
                        foreach ($categories as $cat) {
                            echo '<option value="' . $cat['id_categorie'] . '">' . htmlspecialchars($cat['nom_categorie']) . '</option>';
                        }
                        ?>
                      </select>
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
