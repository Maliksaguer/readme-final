<?php
require_once '../Controller/CategorieController.php';

if (isset($_GET['id'])) {
    $categorieController = new CategorieController();
    $categorieController->deleteCategorie($_GET['id']);

    header('Location: listCategories.php');
    exit();
}
?>
