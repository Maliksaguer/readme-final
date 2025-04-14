<?php
require_once '../Controller/Publication.php';

if (isset($_GET['id'])) {
    $publicationController = new publication();
    $publicationController->deletePublication($_GET['id']);

    header('Location: listPublications.php');
    exit();
} else {
    echo "ID de publication non fourni.";
}
?>
