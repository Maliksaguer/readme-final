<?php
require_once '../Controller/publication.php';
require_once '../Controller/CategorieController.php';

$publication = new publication();
$categorieController = new CategorieController();

if (isset($_GET['id'])) {

    $pub = $publication->showPublication($_GET['id']);
    $categories = $categorieController->listCategories();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $targetDir = "../uploads/";  // Directory to store the uploaded images
        $imagePath = $targetDir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath);
    } else {
        // If no new image is uploaded, keep the existing one
        $imagePath = $_POST['existing_image'];
    }

    // Update publication with the new image path
    $publication->updatePublication(
        $_POST['id_publication'],
        $_POST['titre'],
        $_POST['contenu'],
        $imagePath,  // Save the image path
        $_POST['statut'],
        $_POST['date'],
        $_POST['id_categorie']
    );

    header('Location: listPublications.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Modifier une Publication</title>

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
            <div class="col-md-10 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">

                  <h3 class="text-center mb-4 text-primary">Modifier une Publication</h3>

                  <form method="POST" enctype="multipart/form-data" class="form-section">
                    <input type="hidden" name="id_publication" value="<?= $pub['id_publication'] ?>">
                    <input type="hidden" name="existing_image" value="<?= $pub['image'] ?>">

                    <div class="form-group">
                      <label for="titre">Titre</label>
                      <input type="text" class="form-control" name="titre" value="<?= htmlspecialchars($pub['titre']) ?>" required>
                    </div>

                    <div class="form-group">
                      <label for="contenu">Contenu</label>
                      <textarea class="form-control" name="contenu" rows="5" required><?= htmlspecialchars($pub['contenu']) ?></textarea>
                    </div>

                    <div class="form-group">
                      <label for="image">Choisir une image</label>
                      <input type="file" class="form-control" name="image" accept="image/*">
                      <?php if ($pub['image']): ?>
                        <p>Image actuelle: <img src="<?= $pub['image'] ?>" alt="Image actuelle" style="max-width: 100px;"></p>
                      <?php endif; ?>
                    </div>

                    <div class="form-group">
                      <label for="statut">Statut</label>
                      <input type="text" class="form-control" name="statut" value="<?= htmlspecialchars($pub['statut']) ?>">
                    </div>

                    <div class="form-group">
                      <label for="date">Date</label>
                      <input type="date" class="form-control" name="date" value="<?= htmlspecialchars($pub['date']) ?>">
                    </div>

                    <div class="form-group">
                      <label for="id_categorie">Catégorie</label>
                      <select name="id_categorie" class="form-control" required>
                        <?php foreach ($categories as $cat): ?>
                          <option value="<?= $cat['id_categorie'] ?>" <?= ($cat['id_categorie'] == $pub['id_categorie']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['nom_categorie']) ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>

                    <button type="submit" class="btn btn-warning btn-block mt-3">Modifier</button>
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
